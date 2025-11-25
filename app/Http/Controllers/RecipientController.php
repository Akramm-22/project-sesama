<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;

class RecipientController extends Controller
{
    public const REGION_OPTIONS = [
        'wilayah_1' => 'Wilayah 1 - RW 01',
        'wilayah_2' => 'Wilayah 2 - RW 02',
        'wilayah_3' => 'Wilayah 3 - RW 03',
        'wilayah_4' => 'Wilayah 4 - RW 04',
        'wilayah_5' => 'Wilayah 5 - RW 05',
        'wilayah_6' => 'Wilayah 6 - RW 06',
        'wilayah_7' => 'Wilayah 7 - RW 07',
        'wilayah_8' => 'Wilayah 8 - RW 08',
        'wilayah_9' => 'Wilayah 9 - RW 09',
    ];


    public function index(Request $request)
    {
        $search = $request->input('search');
        $regionFilter = $request->input('region');
        $regionOptions = $this->getRegionOptions();

        $recipients = Recipient::when($search, function ($query, $search) {
                $query->where('child_name', 'LIKE', "%{$search}%");
            })
            ->when($regionFilter, function ($query, $regionFilter) {
                $query->where('region', $regionFilter);
            })
            ->orderBy('child_name', 'asc')
            ->paginate(10)
            ->withQueryString();
        return view('recipients.index', [
            'recipients' => $recipients,
            'regionOptions' => $regionOptions,
            'regionFilter' => $regionFilter,
        ]);
    }

    public function create()
    {
        return view('recipients.create', [
            'regionOptions' => $this->getRegionOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $regionKeys = array_keys($this->getRegionOptions());

        $validated = $request->validate([
            'child_name' => 'required|string|max:255',
            'Ayah_name' => 'required|string|max:255',
            'Ibu_name' => 'required|string|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'age' => 'required|integer|min:1|max:25',
            'address' => 'required|string',
            'region' => ['nullable', Rule::in($regionKeys)],
            'reference_source' => 'nullable|string|max:255',
            'class' => 'required|string|max:255',
            'shoe_size' => 'required|string|max:10',
            'shirt_size' => 'required|string|max:10',
            'id_card_photo' => 'nullable|image|max:2048',
        ]);

        // Generate unique QR code
        $qrCode = $this->generateUniqueQrCode();

        $data = array_merge($validated, [
            'qr_code' => $qrCode,
        ]);

        $data['school_level'] = 'N/A';
        $data['school_name'] = 'N/A';

        $data['id_card_photo_path'] = $this->storeIdCard($request->file('id_card_photo'));
        unset($data['id_card_photo']);

        $recipient = Recipient::create($data);

        return redirect()->route('recipients.index')
            ->with('success', 'Data penerima berhasil ditambahkan dengan QR Code: ' . $qrCode);
    }

    public function show(Recipient $recipient)
    {
        return view('recipients.show', [
            'recipient' => $recipient,
            'regionLabel' => $recipient->region
                ? ($this->getRegionOptions()[$recipient->region] ?? $recipient->region)
                : null,
        ]);
    }

    public function edit(Recipient $recipient)
    {
        return view('recipients.edit', [
            'recipient' => $recipient,
            'regionOptions' => $this->getRegionOptions(),
        ]);
    }

    public function update(Request $request, Recipient $recipient)
    {
        $regionKeys = array_keys($this->getRegionOptions());

        $validated = $request->validate([
            'qr_code' => 'nullable|string',
            'child_name' => 'required|string|max:255',
            'Ayah_name' => 'required|string|max:255',
            'Ibu_name' => 'required|string|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'age' => 'required|integer|min:1|max:25',
            'address' => 'required|string',
            'region' => ['nullable', Rule::in($regionKeys)],
            'reference_source' => 'nullable|string|max:255',
            'class' => 'required|string|max:255',
            'shoe_size' => 'required|string|max:50',
            'shirt_size' => 'required|string|max:50',
            'uniform_received' => 'nullable|boolean',
            'shoes_received' => 'nullable|boolean',
            'bag_received' => 'nullable|boolean',
            'is_distributed' => 'nullable|boolean',
            'distributed_at' => 'nullable|date',
            'has_circumcision' => 'nullable|boolean',
            'has_received_gift' => 'nullable|boolean',
            'has_photo_booth' => 'nullable|boolean',
            'id_card_photo' => 'nullable|image|max:2048',
        ]);

        $data = $validated;
        $data['school_level'] = 'N/A';
        $data['school_name'] = 'N/A';
        $data['id_card_photo_path'] = $this->storeIdCard($request->file('id_card_photo'), $recipient->id_card_photo_path);
        unset($data['id_card_photo']);

        $recipient->update($data);

        return redirect()
            ->route('recipients.index')
            ->with('success', 'Data penerima berhasil diperbarui.');
    }


    public function destroy(Recipient $recipient)
    {
        $recipient->delete();
        return redirect()->route('recipients.index')
            ->with('success', 'Data penerima berhasil dihapus');
    }

    public function generateQrCode(Recipient $recipient)
    {

        $qrCode = QrCode::size(200)
            ->format('png')
            ->generate($recipient->qr_code);

        return response($qrCode, 200)
            ->header('Content-Type', 'image/png');
    }

    public function printQrCode(Recipient $recipient)
    {
        // Canvas
        $width = 350;
        $height = 450;
        $image = imagecreatetruecolor($width, $height);

        // Warna
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $blue  = imagecolorallocate($image, 0, 113, 188);
        $gray  = imagecolorallocate($image, 102, 102, 102);

        // Background putih
        imagefilledrectangle($image, 0, 0, $width, $height, $white);

        // Border
        imagerectangle($image, 0, 0, $width - 1, $height - 1, $black);

        // Header
        imagestring($image, 5, 80, 15, 'BAZMA PERTAMINA', $black);
        imagestring($image, 3, 80, 35, 'Menebar Kebermanfaatan', $black);

        // QR code
        $qrTempPath = storage_path('app/temp-qr.png');
        QrCode::format('png')->size(150)->generate($recipient->qr_code, $qrTempPath);
        $qrImg = imagecreatefrompng($qrTempPath);
        imagecopy($image, $qrImg, 100, 60, 0, 0, 150, 150);
        imagedestroy($qrImg);
        unlink($qrTempPath);

        // QR text
        imagestring($image, 5, 120, 220, $recipient->qr_code, $blue);

        // Info penerima
        $info = [
            'Nama'    => $recipient->child_name,
            'Ayah'    => $recipient->Ayah_name,
            'Ibu'     => $recipient->Ibu_name,
            'Umur'    => $recipient->age ? $recipient->age . ' Tahun' : '-',
            'Kelas'   => $recipient->class,
        ];
        $y = 250;
        foreach ($info as $label => $value) {
            imagestring($image, 3, 20, $y, $label . ':', $black);
            imagestring($image, 3, 100, $y, $value, $black);
            $y += 18;
        }

        // Footer
        imagestring($image, 2, 20, $height - 35, 'Scan QR ini saat penyaluran bantuan', $gray);
        imagestring($image, 2, 20, $height - 20, 'Program Cilincing - Jakarta Utara', $gray);

        // Output PNG untuk auto-download
        return response()->stream(function () use ($image) {
            imagepng($image);
            imagedestroy($image);
        }, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="qr-code.png"',
        ]);
    }




    public function printAllQrCodes()
    {
        $recipients = Recipient::all();

        if ($recipients->isEmpty()) {
            return back()->with('error', 'Tidak ada data penerima.');
        }

        // Folder sementara untuk PNG
        $tempDir = storage_path('app/temp_qr_codes');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $zipFile = storage_path('app/qr_codes_all.zip');
        $zip = new ZipArchive;

        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($recipients as $recipient) {
                // Buat PNG dengan desain yang sama seperti printQrCode()
                $width = 350;
                $height = 450;
                $image = imagecreatetruecolor($width, $height);

                // Warna
                $white = imagecolorallocate($image, 255, 255, 255);
                $black = imagecolorallocate($image, 0, 0, 0);
                $blue  = imagecolorallocate($image, 0, 113, 188);
                $gray  = imagecolorallocate($image, 102, 102, 102);

                // Background putih
                imagefilledrectangle($image, 0, 0, $width, $height, $white);

                // Border
                imagerectangle($image, 0, 0, $width - 1, $height - 1, $black);

                // Header
                imagestring($image, 5, 80, 15, 'BAZMA PERTAMINA', $black);
                imagestring($image, 3, 80, 35, 'Menebar Kebermanfaatan', $black);

                // QR code sementara
                $qrTempPath = storage_path('app/temp-qr.png');
                QrCode::format('png')->size(150)->generate($recipient->qr_code, $qrTempPath);
                $qrImg = imagecreatefrompng($qrTempPath);
                imagecopy($image, $qrImg, 100, 60, 0, 0, 150, 150);
                imagedestroy($qrImg);
                unlink($qrTempPath);

                // QR text
                imagestring($image, 5, 120, 220, $recipient->qr_code, $blue);

                // Info penerima
                $info = [
                    'Nama'    => $recipient->child_name,
                    'Ayah'    => $recipient->Ayah_name,
                    'Ibu'     => $recipient->Ibu_name,
                    'Umur'    => $recipient->age ? $recipient->age . ' Tahun' : '-',
                    'Kelas'   => $recipient->class,
                ];
                $y = 250;
                foreach ($info as $label => $value) {
                    imagestring($image, 3, 20, $y, $label . ':', $black);
                    imagestring($image, 3, 100, $y, $value, $black);
                    $y += 18;
                }

                // Footer
                imagestring($image, 2, 20, $height - 35, 'Scan QR ini saat penyaluran bantuan', $gray);
                imagestring($image, 2, 20, $height - 20, 'Program Cilincing - Jakarta Utara', $gray);

                // Simpan PNG ke folder sementara
                $pngPath = $tempDir . '/qr-code-' . $recipient->qr_code . '.png';
                imagepng($image, $pngPath);
                imagedestroy($image);

                // Masukkan ke ZIP
                $zip->addFile($pngPath, basename($pngPath));
            }

            $zip->close();
        } else {
            return back()->with('error', 'Gagal membuat file ZIP.');
        }

        // Hapus file PNG sementara
        foreach (glob($tempDir . '/*.png') as $file) {
            unlink($file);
        }
        rmdir($tempDir);

        // Download ZIP
        return response()->download($zipFile)->deleteFileAfterSend(true);
    }


    public function scanQr()
    {
        return view('recipients.scan');
    }

    public function verifyQr(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        try {
            $qrInput = $request->qr_code;

            $recipient = Recipient::where('qr_code', $qrInput)->first();

            if (!$recipient) {
                return response()->json(['error' => 'QR Code tidak ditemukan'], 404);
            }

            // BELUM REGISTRASI
            if (!$recipient->registrasi) {
                return response()->json([
                    'error' => 'Penerima belum registrasi'
                ], 403);
            }

            // SUDAH PERNAH DISTRIBUSI
            if ($recipient->is_distributed) {
                return response()->json([
                    'error' => 'Penerima sudah menerima bantuan (tidak boleh ambil dua kali)'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'recipient' => $recipient
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'QR Code tidak valid: ' . $e->getMessage()], 400);
        }
    }





    public function distribute(Request $request, Recipient $recipient)
    {
        if (!$recipient->registrasi) {
            return response()->json([
                'success' => false,
                'error' => 'Penerima belum registrasi'
            ], 403);
        }

        if ($recipient->is_distributed) {
            return response()->json([
                'success' => false,
                'error' => 'Penerima sudah menerima bantuan'
            ], 403);
        }

        $validated = $request->validate([
            'delivery_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
            'registrasi' => 'nullable|boolean',
            'has_circumcision' => 'nullable|boolean',
            'has_received_gift' => 'nullable|boolean',
            'has_photo_booth' => 'nullable|boolean',
        ]);

        try {
            $deliveredAt = Carbon::parse($validated['delivery_date'])
                ->setTime(now()->format('H'), now()->format('i'));

            $recipient->update([
                'registrasi' => true,
                'is_distributed' => true,
                'distributed_at' => $deliveredAt,
                'has_circumcision' => $request->boolean('has_circumcision'),
                'has_received_gift' => $request->boolean('has_received_gift'),
                'has_photo_booth' => $request->boolean('has_photo_booth'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status penyaluran berhasil diperbarui',
                'recipient_id' => $recipient->id,
                'distributed_at' => $recipient->distributed_at?->toDateTimeString(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }


    public function generateReceipt(Recipient $recipient)
    {
        if (!$recipient->is_distributed) {
            return redirect()->back()->with('error', 'Penyaluran belum selesai');
        }

        $encryptedCode = base64_encode($recipient->qr_code . '|' . $recipient->id);

        $pdf = Pdf::loadView('recipients.receipt', compact('recipient', 'encryptedCode'));

        return $pdf->stream('bukti-penerimaan-' . $recipient->qr_code . '.pdf');
    }

    public function generateSignatureForm(Recipient $recipient)
    {
        if (!$recipient->is_distributed) {
            return redirect()->back()->with('error', 'Penyaluran belum selesai');
        }

        $encryptedCode = base64_encode($recipient->qr_code . '|' . $recipient->id);

        $pdf = Pdf::loadView('recipients.signature-form', compact('recipient', 'encryptedCode'));

        return $pdf->stream('form-tanda-tangan-' . $recipient->qr_code . '.pdf');
    }

    public function generateReport()
    {
        $totalRecipients = Recipient::count();
        $distributedCount = Recipient::where('is_distributed', true)->count();
        $pendingCount = Recipient::where('is_distributed', false)->count();

        return response()->json([
            'total_recipients' => $totalRecipients,
            'distributed_count' => $distributedCount,
            'pending_count' => $pendingCount,
            'distributed_percentage' => $totalRecipients > 0
                ? round(($distributedCount / $totalRecipients) * 100, 2)
                : 0
        ]);
    }


    private function generateUniqueQrCode()
    {
        do {
            // Get the next available number
            $lastRecipient = Recipient::orderBy('id', 'desc')->first();
            $nextNumber = $lastRecipient ? $lastRecipient->id + 1 : 1;

            $qrCode = 'CBP' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        } while (Recipient::where('qr_code', $qrCode)->exists());

        return $qrCode;
    }

    private function getRegionOptions(): array
    {
        return self::REGION_OPTIONS;
    }

    private function storeIdCard(?UploadedFile $file, ?string $previousPath = null): ?string
    {
        if (!$file) {
            return $previousPath;
        }

        if ($previousPath && Storage::disk('public')->exists($previousPath)) {
            Storage::disk('public')->delete($previousPath);
        }

        return $file->store('id-cards', 'public');
    }

    public function verifyQrRegistration(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        try {
            $qrInput = $request->qr_code;

            // Cari penerima berdasarkan QR Code
            $recipient = Recipient::where('qr_code', $qrInput)->first();

            if (!$recipient) {
                return response()->json(['error' => 'QR Code tidak ditemukan'], 404);
            }

            // Jika sudah registrasi, beri info
            if ($recipient->registrasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Penerima ini sudah terdaftar (registrasi sudah dilakukan).',
                    'recipient' => $recipient
                ], 200);
            }

            // Kalau belum, kirim data untuk ditampilkan di halaman registrasi
            return response()->json([
                'success' => true,
                'recipient' => $recipient
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'QR Code tidak valid: ' . $e->getMessage()], 400);
        }
    }

    public function markRegistered(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        try {
            $recipient = Recipient::where('qr_code', $request->qr_code)->first();

            if (!$recipient) {
                return response()->json(['error' => 'QR Code tidak ditemukan'], 404);
            }

            if ($recipient->registrasi) {
                return response()->json(['error' => 'Penerima sudah registrasi'], 400);
            }

            $recipient->registrasi = true;
            $recipient->save();

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil disimpan',
                'recipient' => $recipient
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal memperbarui registrasi: ' . $e->getMessage()
            ], 400);
        }
    }
}
