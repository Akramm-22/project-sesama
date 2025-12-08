<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $regions = [
            'Dumai',
            'Cilacap',
            'Cirebon',
            'Plaju',
            'Pertamina Retail',
            'Pertamina EP',
            'Balikpapan',
            'Prabumulih',
            'Balongan',
            'Bazma Pusat',
        ];

        foreach ($regions as $region) {

            // untuk membuat email slug
            $slug = strtolower(str_replace(' ', '', $region));

            // setiap region membuat 3 akun admin
            for ($i = 1; $i <= 3; $i++) {

                // password unik
                $plainPassword = $slug . $i . "2025";

                // simpan ke database (hashed)
                User::create([
                    'name'     => "Admin {$region} {$i}",
                    'email'    => "{$slug}{$i}@bansos.com",
                    'role'     => 'admin',
                    'password' => Hash::make($plainPassword),
                ]);

                // tampilkan password asli di console
                echo "Akun : Admin {$region} {$i}\n";
                echo "Email : {$slug}{$i}@bansos.com\n";
                echo "Password : {$plainPassword}\n\n";
            }
        }
    }
}
