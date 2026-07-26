<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Pegawai;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Riwayat perubahan data Pegawai
     */
    public function pegawai(Pegawai $pegawai)
    {
        $logs = ActivityLog::where('loggable_type', Pegawai::class)
            ->where('loggable_id', $pegawai->id)
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('riwayat.pegawai', compact('pegawai', 'logs'));
    }

    /**
     * Riwayat perubahan data Sekolah
     */
    public function sekolah(Sekolah $sekolah)
    {
        $logs = ActivityLog::where('loggable_type', Sekolah::class)
            ->where('loggable_id', $sekolah->id)
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('riwayat.sekolah', compact('sekolah', 'logs'));
    }
}
