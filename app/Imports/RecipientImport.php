<?php

namespace App\Imports;

use App\Models\Recipient;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RecipientImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // Ambil QR terbesar saat ini
            $lastQr = Recipient::orderBy('id', 'desc')->value('qr_code');

            $nextNumber = $lastQr
                ? (int) substr($lastQr, 2) + 1
                : 1;

            // Buat QR format KC00001
            $qr = 'KC' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            Recipient::create([

                // ✅ langsung isi QR (tidak null)
                'qr_code' => $qr,

                'child_name'        => $row['child_name'],
                'Ayah_name'         => $row['ayah_name'],
                'Ibu_name'          => $row['ibu_name'],
                'whatsapp_number'  => $row['whatsapp_number'] ?? null,
                'birth_date'       => $row['birth_date'],
                'address'          => $row['address'],
                'region'           => $row['region'] ?? null,
                'reference_source' => $row['reference_source'] ?? null,
                'is_distributed'   => filter_var($row['is_distributed'], FILTER_VALIDATE_BOOLEAN),
                'distributed_at'   => $row['distributed_at'] ?: null,
                'created_at'       => now(),
                'updated_at'       => now(),
                'has_circumcision' => filter_var($row['has_circumcision'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'has_received_gift'=> filter_var($row['has_received_gift'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'has_photo_booth'  => filter_var($row['has_photo_booth'] ?? false, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}
