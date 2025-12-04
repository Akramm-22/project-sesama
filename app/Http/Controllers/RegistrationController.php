<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    // Verifikasi QR di halaman registrasi
    public function verifyRegistrationQr(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $qrInput = $request->qr_code;

        // Cari data berdasarkan QR
        $recipient = Recipient::where('qr_code', $qrInput)->first();

        if (!$recipient) {
            return response()->json(['error' => 'QR Code tidak ditemukan'], 404);
        }

        // Kalau sudah terdaftar sebelumnya
        if ($recipient->registrasi) {
            return response()->json(['error' => 'Penerima sudah registrasi'], 400);
        }

        return response()->json([
    'success' => true,
    'recipient' => [
        'qr_code' => $recipient->qr_code,
        'child_name' => $recipient->child_name,
        'Ayah_name' => $recipient->Ayah_name,
        'Ibu_name' => $recipient->Ibu_name,
        'birth_place' => $recipient->birth_place,
        'birth_date' => $recipient->birth_date
            ? Carbon::parse($recipient->birth_date)->format('Y-m-d')
            : null,
        'age' => $recipient->age ?? ($recipient->birth_date ? Carbon::parse($recipient->birth_date)->age : null),
        'whatsapp_number' => $recipient->whatsapp_number,
        'region' => $recipient->region, 
        'address' => $recipient->address,
    ]
]);

    }

    // Konfirmasi Registrasi + Update Data
    public function confirmRegistration(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
            'child_name' => 'required|string|max:255',
            'Ayah_name' => 'nullable|string|max:255',
            'Ibu_name' => 'nullable|string|max:255',
            'birth_date' => 'required|date',
            'address' => 'nullable|string|max:500',

        ]);

        $recipient = Recipient::where('qr_code', $request->qr_code)->first();

        if (!$recipient) {
            return response()->json(['error' => 'QR Code tidak ditemukan'], 404);
        }

        if ($recipient->registrasi) {
            return response()->json(['error' => 'Penerima sudah registrasi'], 400);
        }

        // Update data
        $recipient->child_name = $request->child_name;
        $recipient->Ayah_name = $request->Ayah_name;
        $recipient->Ibu_name = $request->Ibu_name;
        $recipient->birth_date = $request->birth_date;
        $recipient->whatsapp_number = $request->whatsapp_number;
        $recipient->region = $request->region;
        $recipient->address = $request->address;
        $recipient->registrasi = true;
        $recipient->save();

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui dan registrasi berhasil']);
    }

}
