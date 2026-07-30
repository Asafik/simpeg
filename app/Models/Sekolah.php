<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Sekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'npsn',
        'nama_sekolah',
        'tingkatan',
        'kecamatan',
        'nama_kepala_sekolah',
        'nip_kepala_sekolah',
        'status_kepala_sekolah',
        'email_sekolah',
        'alamat',
    ];

    public function pegawais(): BelongsToMany
    {
        return $this->belongsToMany(Pegawai::class, 'pegawai_sekolah')
                    ->withPivot('is_primary')
                    ->withTimestamps();
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'sekolah_id');
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'loggable')->latest();
    }
}
