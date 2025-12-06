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
        'birth_date',
        'address',
        'region',
        'reference_source',
        'is_distributed',
        'distributed_at',
        'has_circumcision',
        'has_received_gift',
        'has_photo_booth',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
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
