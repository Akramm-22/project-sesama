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
            Recipient::create([
                'qr_code' => $row['qr_code'],
                'child_name' => $row['child_name'],
                'Ayah_name' => $row['ayah_name'],
                'Ibu_name' => $row['ibu_name'],
                'whatsapp_number' => $row['whatsapp_number'] ?? null,
                'birth_date' => $row['birth_date'],
                'address' => $row['address'],
                'region' => $row['region'] ?? null,
                'reference_source' => $row['reference_source'] ?? null,
                'is_distributed' => filter_var($row['is_distributed'], FILTER_VALIDATE_BOOLEAN),
                'distributed_at' => $row['distributed_at'] ?: null,
                'created_at' => $row['created_at'] ?: null,
                'updated_at' => $row['updated_at'] ?: null,
                'has_circumcision' => filter_var($row['has_circumcision'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'has_received_gift' => filter_var($row['has_received_gift'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'has_photo_booth' => filter_var($row['has_photo_booth'] ?? false, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}
