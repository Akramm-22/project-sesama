<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_code',
        'child_name',
        'Ayah_name',
        'Ibu_name',
        'whatsapp_number',
        'registrasi',
        'birth_place',
        'birth_date',
        'age',
        'school_level',
        'school_name',
        'address',
        'region',
        'reference_source',
        'id_card_photo_path',
        'class',
        'shoe_size',
        'shirt_size',
        'uniform_received',
        'shoes_received',
        'bag_received',
        'is_distributed',
        'distributed_at',
        'has_circumcision',
        'has_received_gift',
        'has_photo_booth',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'uniform_received' => 'boolean',
        'shoes_received' => 'boolean',
        'bag_received' => 'boolean',
        'is_distributed' => 'boolean',
        'distributed_at' => 'datetime',
        'has_circumcision' => 'boolean',
        'has_received_gift' => 'boolean',
        'has_photo_booth' => 'boolean',
    ];

    public function isFullyDistributed()
    {
        return $this->uniform_received && $this->shoes_received && $this->bag_received;
    }

    public function getDistributionStatusAttribute()
    {
        if ($this->is_distributed) {
            return 'Sudah Menerima';
        }
        return 'Belum Menerima';
    }
}
