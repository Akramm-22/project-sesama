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

        $defaultPassword = Hash::make('admin123');

        foreach ($regions as $region) {

            for ($i = 1; $i <= 3; $i++) {

                $slug = strtolower(str_replace(' ', '', $region));

                User::create([
                    'name' => "Admin {$region} {$i}",
                    'email' => "{$slug}{$i}@bansos.com",
                    'role' => 'admin',
                    'password' => $defaultPassword,
                ]);

            }
        }
    }
}
