<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'kategori',
        'ringkasan',
        'isi',
        'penulis_id',
        'penulis_nama',
        'is_published',
        'lampiran_file',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }

    public function getKategoriBadgeClassAttribute(): string
    {
        return match ($this->kategori) {
            'Penting'        => 'bg-rose-100 text-rose-800 border-rose-200',
            'Verifikasi'     => 'bg-amber-100 text-amber-800 border-amber-200',
            'Surat Edaran'   => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            'Informasi Umum' => 'bg-blue-100 text-blue-800 border-blue-200',
            default          => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }
}
