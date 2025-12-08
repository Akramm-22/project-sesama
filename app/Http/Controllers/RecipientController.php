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
use Imagick;
use Illuminate\Support\Facades\File;

class RecipientController extends Controller
{
    public const REGION_OPTIONS = [
   'Dumai'        => 'Dumai',
'Cilacap'     => 'Cilacap',
'Prabumulih'      => 'Prabumulih',
'Cirebon'         => 'Cirebon',
'Plaju'      => 'Plaju',
'Pertamina Retail' => 'Pertamina Retail',
'Pertamina EP'        => 'Pertamina EP',
'Balikpapan'    => 'Balikpapan',
'Balongan'     => 'Balongan',
'Bazma Pusat'      => 'Bazma Pusat',

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

            'birth_date' => 'required|date',

            'address' => 'required|string',
            'region' => ['nullable', Rule::in($regionKeys)],
            'reference_source' => 'nullable|string|max:255',
        ]);

        // Generate unique QR code
        $qrCode = $this->generateUniqueQrCode();

        $data = array_merge($validated, [
            'qr_code' => $qrCode,
        ]);


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

            'birth_date' => 'required|date',

            'address' => 'required|string',
            'region' => ['nullable', Rule::in($regionKeys)],
            'reference_source' => 'nullable|string|max:255',
            'is_distributed' => 'nullable|boolean',
            'distributed_at' => 'nullable|date',
            'has_circumcision' => 'nullable|boolean',
            'has_received_gift' => 'nullable|boolean',
            'has_photo_booth' => 'nullable|boolean',
        ]);

        $data = $validated;

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
    return view('recipients.qr-print', compact('recipient'));
}



public function printAllQrCodes()
{
    $recipients = Recipient::all();

    if ($recipients->isEmpty()) {
        return back()->with('error', 'Tidak ada data penerima.');
    }

    $tempDir = storage_path('app/temp_qr_codes');

    if (!file_exists($tempDir)) {
        mkdir($tempDir, 0777, true);
    }

    $zipFile = storage_path('app/qr_codes_all.zip');
    $zip = new ZipArchive;

    if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        return back()->with('error', 'Gagal membuat ZIP.');
    }

    foreach ($recipients as $recipient) {

        $width  = 380;
        $height = 520;

        $image = imagecreatetruecolor($width, $height);

        // ===== COLOR =====
        $bg       = imagecolorallocate($image, 245, 247, 250);
        $white    = imagecolorallocate($image, 255, 255, 255);
        $primary  = imagecolorallocate($image, 0, 91, 172);
        $blue     = imagecolorallocate($image, 0, 113, 188);
        $gray     = imagecolorallocate($image, 120, 120, 120);
        $dark     = imagecolorallocate($image, 40, 40, 40);

        imagefilledrectangle($image, 0, 0, $width, $height, $bg);

        // ===== CARD =====
        imagefilledrectangle($image, 20, 20, $width-20, $height-20, $white);
        imagerectangle($image, 20,20,$width-20,$height-20,$gray);

        // ===== HEADER =====
        imagestring($image, 5, 105, 45, 'KHITANAN CERIA', $primary);
        imagestring($image, 3, 120, 70, 'Menebar Kebermanfaatan', $gray);

        // ===== QR =====
        $qrTempPath = storage_path('app/temp-qr.png');
        QrCode::format('png')->size(160)->generate($recipient->qr_code, $qrTempPath);
        $qrImg = imagecreatefrompng($qrTempPath);

        imagecopy($image, $qrImg, 110, 105, 0, 0, 160, 160);
        imagedestroy($qrImg);
        unlink($qrTempPath);

        // QR number
        imagestring($image, 5, 140, 275, $recipient->qr_code, $blue);

        // ===== TABLE INFO =====
        $y = 310;

        $info = [
            'Nama'      => $recipient->child_name,
            'Ayah'      => $recipient->Ayah_name,
            'Ibu'       => $recipient->Ibu_name,
            'Lahir'     => $recipient->birth_date
                                ? \Carbon\Carbon::parse($recipient->birth_date)->format('d-m-Y')
                                : '-',
            'WhatsApp'  => $recipient->whatsapp_number ?? '-'
        ];

        foreach ($info as $label => $value)
        {
            imagestring($image, 3, 40, $y, $label, $dark);
            imagestring($image, 3, 155, $y, ': ' . $value, $dark);
            $y += 22;
        }

        // ===== FOOTER =====
        imagestring($image, 2, 55, $height - 55, 'Scan QR ini saat registrasi penyaluran', $gray);
        imagestring($image, 2, 120, $height - 35, 'Program Khitanan Ceria', $gray);

        // ===== SAVE PNG =====
        $pngPath = $tempDir . '/QR-' . $recipient->qr_code . '.png';
        imagepng($image, $pngPath);
        imagedestroy($image);

        // ===== ADD TO ZIP =====
        $zip->addFile($pngPath, basename($pngPath));
    }

    $zip->close();

    // ===== CLEANUP =====
    foreach (glob($tempDir . '/*') as $file) {
        if (is_file($file)) unlink($file);
    }
    rmdir($tempDir);

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

    $recipient = Recipient::where('qr_code', $request->qr_code)->first();

    if (!$recipient) {
        return response()->json(['error' => 'QR Code tidak ditemukan'], 404);
    }

    if (!$recipient->registrasi) {
        return response()->json([
            'error' => 'Penerima belum registrasi'
        ], 403);
    }

    if ($recipient->is_distributed) {
        return response()->json([
            'error' => 'Penerima sudah menerima bantuan'
        ], 403);
    }

    return response()->json([
        'success' => true,
        'recipient' => [
            'id' => $recipient->id,
            'qr_code' => $recipient->qr_code,

            'child_name' => $recipient->child_name,
            'Ayah_name' => $recipient->Ayah_name,
            'Ibu_name' => $recipient->Ibu_name,

            'registrasi' => (bool)$recipient->registrasi,
            'has_circumcision' => (bool)$recipient->has_circumcision,
            'has_received_gift' => (bool)$recipient->has_received_gift,
            'has_photo_booth' => (bool)$recipient->has_photo_booth,
        ]
    ]);
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
                 'notes' => $validated['notes'] ?? null,
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

    // =======================
    // status penyaluran pdf download

    public function exportDistribution(Recipient $recipient)
{
    $pdf = Pdf::loadView('recipients.pdf.distribution', [
        'recipient' => $recipient
    ])->setPaper('A4', 'portrait');

    return $pdf->download('Informasi-Penyaluran-'.$recipient->qr_code.'.pdf');
}

// status penyaluran

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
