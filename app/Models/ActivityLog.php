<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'loggable_type',
        'loggable_id',
        'action',
        'label',
        'changes',
        'user_id',
        'user_name',
        'user_role',
        'ip_address',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get a human-friendly label for the action.
     */
    public function getActionLabelAttribute(): string
    {
        return match ($this->action) {
            'created'  => '➕ Data Ditambahkan',
            'updated'  => '✏️ Data Diubah',
            'deleted'  => '🗑 Data Dihapus',
            'imported' => '📥 Import Excel',
            'exported' => '📤 Export Excel',
            default    => ucfirst($this->action),
        };
    }

    /**
     * Get badge CSS class for each action type.
     */
    public function getActionBadgeClassAttribute(): string
    {
        return match ($this->action) {
            'created'  => 'bg-emerald-100 text-emerald-800',
            'updated'  => 'bg-blue-100 text-blue-800',
            'deleted'  => 'bg-red-100 text-red-800',
            'imported' => 'bg-indigo-100 text-indigo-800',
            'exported' => 'bg-gray-100 text-gray-700',
            default    => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Human-readable column name labels for Pegawai.
     */
    public static function pegawaiFieldLabel(string $field): string
    {
        $labels = [
            'nama_lengkap'       => 'Nama Lengkap',
            'nip_nik'            => 'NIP',
            'nik'                => 'NIK',
            'status_kepegawaian' => 'Status Kepegawaian',
            'pangkat_golongan'   => 'Pangkat / Golongan',
            'jabatan_fungsional' => 'Jabatan Fungsional',
            'no_sk_jabfung'      => 'No. SK Jabfung',
            'tmt_jabfung'        => 'TMT Jabfung',
            'is_serdik'          => 'Sertifikasi (Serdik)',
            'no_serdik'          => 'Nomor Sertifikasi',
            'tgl_serdik'         => 'Tanggal Sertifikasi',
            'jenis_ptk'          => 'Jenis PTK',
            'jenis_guru'         => 'Jenis Guru',
            'jumlah_jp'          => 'Jumlah JP',
            'nuptk'              => 'NUPTK',
            'tingkat_pendidikan' => 'Tingkat Pendidikan',
            'jurusan_prodi'      => 'Jurusan / Prodi',
            'tempat_lahir'       => 'Tempat Lahir',
            'tanggal_lahir'      => 'Tanggal Lahir',
            'jenis_kelamin'      => 'Jenis Kelamin',
            'agama'              => 'Agama',
            'sekolah_id'         => 'Satuan Pendidikan',
            'file_sk'            => 'File SK',
            'file_serdik'        => 'File Sertifikasi',
            'file_ijazah'        => 'File Ijazah',
        ];
        return $labels[$field] ?? ucwords(str_replace('_', ' ', $field));
    }

    /**
     * Human-readable column name labels for Sekolah.
     */
    public static function sekolahFieldLabel(string $field): string
    {
        $labels = [
            'npsn'                  => 'Kode NPSN',
            'nama_sekolah'          => 'Nama Satuan Pendidikan',
            'kecamatan'             => 'Kecamatan',
            'nama_kepala_sekolah'   => 'Nama Kepala Sekolah',
            'nip_kepala_sekolah'    => 'NIP Kepala Sekolah',
            'status_kepala_sekolah' => 'Status Kepemimpinan',
            'email_sekolah'         => 'Email Resmi Sekolah',
            'alamat'                => 'Alamat',
        ];
        return $labels[$field] ?? ucwords(str_replace('_', ' ', $field));
    }

    /**
     * Log a model change.
     */
    public static function record(
        Model $model,
        string $action,
        array $changes = [],
        string $label = ''
    ): void {
        try {
            $user = auth()->user();
            self::create([
                'loggable_type' => get_class($model),
                'loggable_id'   => $model->getKey(),
                'action'        => $action,
                'label'         => $label ?: ucfirst($action) . ' ' . class_basename($model),
                'changes'       => !empty($changes) ? $changes : null,
                'user_id'       => $user?->id,
                'user_name'     => $user?->name ?? 'System',
                'user_role'     => $user?->role ?? 'System',
                'ip_address'    => request()->ip(),
            ]);
        } catch (\Throwable $e) {
            // Silent fail - never break main app flow
        }
    }
}
