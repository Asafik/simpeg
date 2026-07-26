<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'sekolah_id',
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
        'file_sk',
        'file_serdik',
        'file_ijazah',
    ];

    protected $casts = [
        'is_serdik' => 'boolean',
        'tanggal_lahir' => 'date',
    ];

    protected $appends = ['usia'];

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    public function getUsiaAttribute(): int
    {
        return $this->tanggal_lahir ? Carbon::parse($this->tanggal_lahir)->age : 0;
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
                  ->orWhereHas('sekolah', function ($qSekolah) use ($search, $cleanSearch) {
                      $qSekolah->where('nama_sekolah', 'like', "%{$search}%")
                               ->orWhereRaw("REPLACE(LOWER(nama_sekolah), ' ', '') LIKE ?", ["%{$cleanSearch}%"])
                               ->orWhere('npsn', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['sekolah_id'])) {
            $query->where('sekolah_id', $filters['sekolah_id']);
        }

        if (!empty($filters['kecamatan'])) {
            $query->whereHas('sekolah', function ($q) use ($filters) {
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

        return $query;
    }
}
