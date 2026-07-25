<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Sekolah;
use App\Models\ExcelImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $pegawaiQuery = Pegawai::query();
        $sekolahQuery = Sekolah::query();

        // Operator sekolah only sees their own school
        if ($user->isOperatorSekolah() && $user->sekolah_id) {
            $pegawaiQuery->where('sekolah_id', $user->sekolah_id);
            $sekolahQuery->where('id', $user->sekolah_id);
        }

        $totalSekolah = $sekolahQuery->count();
        $totalPegawai = (clone $pegawaiQuery)->count();
        $totalPns = (clone $pegawaiQuery)->where('status_kepegawaian', 'PNS')->count();
        $totalPppk = (clone $pegawaiQuery)->where('status_kepegawaian', 'PPPK')->count();
        $totalPppkPw = (clone $pegawaiQuery)->where('status_kepegawaian', 'PPPK PW')->count();
        $totalNonAsn = (clone $pegawaiQuery)->where('status_kepegawaian', 'Non-ASN')->count();
        $totalSerdik = (clone $pegawaiQuery)->where('is_serdik', true)->count();
        $persenSerdik = $totalPegawai > 0 ? round(($totalSerdik / $totalPegawai) * 100, 1) : 0;

        // Stat per Status Kepegawaian (for Pie Chart)
        $statusChartData = [
            'PNS' => $totalPns,
            'PPPK' => $totalPppk,
            'PPPK PW' => $totalPppkPw,
            'Non-ASN' => $totalNonAsn,
        ];

        // Stat per Pendidikan (for Bar Chart)
        $pendidikanData = (clone $pegawaiQuery)
            ->select('tingkat_pendidikan', DB::raw('count(*) as total'))
            ->groupBy('tingkat_pendidikan')
            ->pluck('total', 'tingkat_pendidikan')
            ->toArray();

        // Stat Usia (<30, 31-40, 41-50, >50)
        $today = Carbon::today();
        $usiaData = [
            '<30 Thn' => (clone $pegawaiQuery)->where('tanggal_lahir', '>', $today->copy()->subYears(30))->count(),
            '31-40 Thn' => (clone $pegawaiQuery)->whereBetween('tanggal_lahir', [$today->copy()->subYears(40), $today->copy()->subYears(30)])->count(),
            '41-50 Thn' => (clone $pegawaiQuery)->whereBetween('tanggal_lahir', [$today->copy()->subYears(50), $today->copy()->subYears(40)])->count(),
            '>50 Thn' => (clone $pegawaiQuery)->where('tanggal_lahir', '<=', $today->copy()->subYears(50))->count(),
        ];

        // Stat per Kecamatan (for Admin Dinas)
        $kecamatanData = [];
        if ($user->isAdminDinas()) {
            $kecamatanData = DB::table('pegawais')
                ->join('sekolahs', 'pegawais.sekolah_id', '=', 'sekolahs.id')
                ->select('sekolahs.kecamatan', DB::raw('count(pegawais.id) as total'))
                ->groupBy('sekolahs.kecamatan')
                ->pluck('total', 'sekolahs.kecamatan')
                ->toArray();
        }

        $recentPegawai = (clone $pegawaiQuery)->with('sekolah')->latest()->take(5)->get();
        $recentImports = ExcelImport::with('user')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalSekolah',
            'totalPegawai',
            'totalPns',
            'totalPppk',
            'totalPppkPw',
            'totalNonAsn',
            'totalSerdik',
            'persenSerdik',
            'statusChartData',
            'pendidikanData',
            'usiaData',
            'kecamatanData',
            'recentPegawai',
            'recentImports'
        ));
    }
}
