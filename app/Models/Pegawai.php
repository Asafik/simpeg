<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip_nik',
        'nik',
        'nama_lengkap',
        'status_kepegawaian',
        'pangkat_golongan',
        'jabatan_fungsional',
        'no_sk_jabfung',
        'tmt_jabfung',
        'is_serdik',
        'no_serdik',
        'tgl_serdik',
        'jenis_ptk',
        'jenis_guru',
        'jumlah_jp',
        'nuptk',
        'tingkat_pendidikan',
        'jurusan_prodi',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'photo_profile',
        'file_sk',
        'file_serdik',
        'file_ijazah',
        'status_verifikasi',
        'catatan_verifikasi',
        'tgl_verifikasi',
        'verified_by',
    ];

    protected $casts = [
        'is_serdik' => 'boolean',
        'tanggal_lahir' => 'date',
        'tgl_verifikasi' => 'datetime',
        'file_sk' => 'array',
        'file_serdik' => 'array',
        'file_ijazah' => 'array',
    ];

    protected $appends = ['usia', 'initials', 'profile_picture_url'];

    /**
     * Many-to-Many: Pegawai bisa bertugas di banyak sekolah.
     */
    public function sekolahs(): BelongsToMany
    {
        return $this->belongsToMany(Sekolah::class, 'pegawai_sekolah')
                    ->withPivot('is_primary')
                    ->withTimestamps();
    }

    /**
     * Accessor: Mendapatkan sekolah utama (primary) pegawai.
     * Backward-compatible — kode lama yang pakai $pegawai->sekolah tetap berfungsi.
     */
    public function getSekolahAttribute()
    {
        if ($this->relationLoaded('sekolahs')) {
            return $this->sekolahs->where('pivot.is_primary', true)->first()
                ?? $this->sekolahs->first();
        }

        return $this->sekolahs()->wherePivot('is_primary', true)->first()
            ?? $this->sekolahs()->first();
    }

    /**
     * Accessor: Mendapatkan sekolah_id utama (untuk backward compatibility).
     */
    public function getSekolahIdAttribute()
    {
        return $this->sekolah?->id;
    }



    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function getUsiaAttribute(): int
    {
        return $this->tanggal_lahir ? Carbon::parse($this->tanggal_lahir)->age : 0;
    }

    public function getInitialsAttribute(): string
    {
        $name = trim($this->nama_lengkap);
        if (empty($name)) {
            return 'U';
        }

        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }
        return substr($initials, 0, 2);
    }

    public function getProfilePictureUrlAttribute(): ?string
    {
        if ($this->photo_profile) {
            return asset('storage/' . $this->photo_profile);
        }
        return null;
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'loggable')->latest();
    }

    // Filter Scope for 7 Criteria
    public function scopeFilterKriteria($query, array $filters)
    {
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $cleanSearch = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($search));
            $query->where(function ($q) use ($search, $cleanSearch) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhereRaw("REPLACE(LOWER(nama_lengkap), ' ', '') LIKE ?", ["%{$cleanSearch}%"])
                  ->orWhere('nip_nik', 'like', "%{$search}%")
                  ->orWhereHas('sekolahs', function ($qSekolah) use ($search, $cleanSearch) {
                      $qSekolah->where('nama_sekolah', 'like', "%{$search}%")
                               ->orWhereRaw("REPLACE(LOWER(nama_sekolah), ' ', '') LIKE ?", ["%{$cleanSearch}%"])
                               ->orWhere('npsn', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['sekolah_id'])) {
            $query->whereHas('sekolahs', function ($q) use ($filters) {
                $q->where('sekolahs.id', $filters['sekolah_id']);
            });
        }

        if (!empty($filters['kecamatan'])) {
            $query->whereHas('sekolahs', function ($q) use ($filters) {
                $q->where('kecamatan', $filters['kecamatan']);
            });
        }

        if (!empty($filters['status_kepegawaian'])) {
            $query->where('status_kepegawaian', $filters['status_kepegawaian']);
        }

        if (!empty($filters['jabatan_fungsional'])) {
            $query->where('jabatan_fungsional', $filters['jabatan_fungsional']);
        }

        if (isset($filters['is_serdik']) && $filters['is_serdik'] !== null && $filters['is_serdik'] !== '') {
            $query->where('is_serdik', (int) $filters['is_serdik']);
        }

        if (!empty($filters['jenis_ptk'])) {
            $query->where('jenis_ptk', $filters['jenis_ptk']);
        }

        if (!empty($filters['jenis_guru'])) {
            $jGuru = $filters['jenis_guru'];
            if ($jGuru === 'Guru Mapel') {
                $query->whereIn('jenis_guru', ['Guru Mapel', 'Guru Mata Pelajaran']);
            } else {
                $query->where('jenis_guru', $jGuru);
            }
        }

        if (!empty($filters['tingkat_pendidikan'])) {
            $query->where('tingkat_pendidikan', $filters['tingkat_pendidikan']);
        }

        if (!empty($filters['kelompok_usia'])) {
            $today = \Carbon\Carbon::today();
            switch ($filters['kelompok_usia']) {
                case '<30':
                    $query->where('tanggal_lahir', '>', $today->copy()->subYears(30));
                    break;
                case '30-40':
                case '31-40':
                    $query->whereBetween('tanggal_lahir', [
                        $today->copy()->subYears(40),
                        $today->copy()->subYears(30)
                    ]);
                    break;
                case '41-50':
                    $query->whereBetween('tanggal_lahir', [
                        $today->copy()->subYears(50),
                        $today->copy()->subYears(40)
                    ]);
                    break;
                case '>50':
                case '>55':
                    $query->where('tanggal_lahir', '<=', $today->copy()->subYears(50));
                    break;
            }
        }

        if (isset($filters['multi_sekolah']) && $filters['multi_sekolah'] !== '' && $filters['multi_sekolah'] !== null) {
            if ($filters['multi_sekolah'] === '1' || $filters['multi_sekolah'] === 'ya') {
                $query->has('sekolahs', '>', 1);
            } elseif ($filters['multi_sekolah'] === '0' || $filters['multi_sekolah'] === 'tidak') {
                $query->has('sekolahs', '=', 1);
            }
        }

        return $query;
    }
}
