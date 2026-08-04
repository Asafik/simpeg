<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the main SIMPEG-SP admin dashboard with real dynamic data.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $pegawaiQuery = Pegawai::query();
        $sekolahQuery = Sekolah::query();

        // Scope queries if logged in as Operator Sekolah
        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
            $sekolahId = $user->sekolah_id ?? -1;
            $pegawaiQuery->whereHas('sekolahs', fn($q) => $q->where('sekolahs.id', $sekolahId));
            $sekolahQuery->where('id', $sekolahId);
        }

        // Summary Card Stats
        $totalSekolah = (clone $sekolahQuery)->count();
        $totalPegawai = (clone $pegawaiQuery)->count();
        $totalMultiSekolah = (clone $pegawaiQuery)->has('sekolahs', '>', 1)->count();

        // Tingkatan (Jenjang) Stats
        $totalTK = (clone $sekolahQuery)->where('tingkatan', 'TK')->count();
        $totalSD = (clone $sekolahQuery)->where('tingkatan', 'SD')->count();
        $totalSMP = (clone $sekolahQuery)->where('tingkatan', 'SMP')->count();
        $totalSMA = (clone $sekolahQuery)->where('tingkatan', 'SMA')->count();

        $totalPns = (clone $pegawaiQuery)->where('status_kepegawaian', 'PNS')->count();
        $totalPppk = (clone $pegawaiQuery)->where('status_kepegawaian', 'PPPK')->count();
        $totalPppkPw = (clone $pegawaiQuery)->where('status_kepegawaian', 'PPPK PW')->count();
        $totalNonAsn = (clone $pegawaiQuery)->where('status_kepegawaian', 'Non-ASN')->count();

        // Kepala Sekolah Stats
        $totalDefinitif = (clone $sekolahQuery)->where('status_kepala_sekolah', 'Definitif')->count();
        $totalPlt = (clone $sekolahQuery)->where('status_kepala_sekolah', 'Plt')->count();
        $totalPlh = (clone $sekolahQuery)->where('status_kepala_sekolah', 'Plh')->count();

        // Chart 1 & Chart 2 Stats based on user role
        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
            $totalOperator = User::where('role', 'OPERATOR_SEKOLAH')->where('sekolah_id', $user->sekolah_id ?? -1)->count();

            // Chart 1 for Operator: Status Kepegawaian Sekolah Operator
            $chart1Title = "Komposisi Kepegawaian (Sekolah Anda)";
            $chart1Sub = "Distribusi status kepegawaian internal di sekolah tempat Anda bertugas.";
            $chart1DatasetLabel = "Jumlah Pegawai";
            $kecamatanLabels = ['PNS', 'PPPK', 'PPPK PW', 'Non-ASN'];
            $kecamatanData = [$totalPns, $totalPppk, $totalPppkPw, $totalNonAsn];

            // Chart 2 for Operator: Sertifikasi Pendidik (Serdik)
            $totalSerdik = (clone $pegawaiQuery)->where('is_serdik', true)->count();
            $totalNonSerdik = (clone $pegawaiQuery)->where(function($q) {
                $q->where('is_serdik', false)->orWhereNull('is_serdik');
            })->count();

            $chart2Title = "Sertifikasi Pendidik (Serdik)";
            $chart2Sub = "Perbandingan Pendidik yang Sudah & Belum Memiliki Serdik.";
            $statusKepsekLabels = ['Sudah Serdik', 'Belum Serdik'];
            $statusKepsekData = [$totalSerdik, $totalNonSerdik];
        } else {
            $totalOperator = User::where('role', 'OPERATOR_SEKOLAH')->count();

            // Chart 1 for Admin: Top 7 Kecamatan by Total Schools
            $chart1Title = "Persebaran Satuan Pendidikan Terbanyak (Per Kecamatan)";
            $chart1Sub = "Top 7 Kecamatan dengan jumlah sekolah terbanyak di database real.";
            $chart1DatasetLabel = "Jumlah Sekolah";

            $kecamatanStats = Sekolah::select('kecamatan', DB::raw('count(*) as total'))
                ->whereNotNull('kecamatan')
                ->where('kecamatan', '!=', '')
                ->groupBy('kecamatan')
                ->orderByDesc('total')
                ->limit(7)
                ->get();

            $kecamatanLabels = $kecamatanStats->pluck('kecamatan')->toArray();
            $kecamatanData = $kecamatanStats->pluck('total')->toArray();

            // Chart 2 for Admin: Status Kepala Sekolah Breakdown
            $chart2Title = "Status Kepala Sekolah";
            $chart2Sub = "Perbandingan status Kepala Sekolah Definitif vs Plt/Plh.";
            $statusKepsekLabels = ['Definitif', 'Plt', 'Plh'];
            $statusKepsekData = [$totalDefinitif, $totalPlt, $totalPlh];
        }

        // Recent Sekolahs & Recent Pegawais List
        $recentSekolahs = (clone $sekolahQuery)->withCount('pegawais')->with('users')->latest()->take(6)->get();
        $recentPegawais = (clone $pegawaiQuery)->with('sekolahs')->latest()->take(6)->get();

        return view('dashboard', compact(
            'totalSekolah',
            'totalPegawai',
            'totalMultiSekolah',
            'totalTK',
            'totalSD',
            'totalSMP',
            'totalSMA',
            'totalPns',
            'totalPppk',
            'totalPppkPw',
            'totalNonAsn',
            'totalDefinitif',
            'totalPlt',
            'totalPlh',
            'totalOperator',
            'chart1Title',
            'chart1Sub',
            'chart1DatasetLabel',
            'chart2Title',
            'chart2Sub',
            'kecamatanLabels',
            'kecamatanData',
            'statusKepsekLabels',
            'statusKepsekData',
            'recentSekolahs',
            'recentPegawais'
        ));
    }
}

