<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'npsn',
        'nama_sekolah',
        'kecamatan',
        'nama_kepala_sekolah',
        'nip_kepala_sekolah',
        'status_kepala_sekolah',
        'email_sekolah',
        'alamat',
    ];

    public function pegawais(): HasMany
    {
        return $this->hasMany(Pegawai::class, 'sekolah_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'sekolah_id');
    }
}
