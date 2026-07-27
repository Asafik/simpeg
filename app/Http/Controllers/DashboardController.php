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
        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah() && $user->sekolah_id) {
            $pegawaiQuery->where('sekolah_id', $user->sekolah_id);
            $sekolahQuery->where('id', $user->sekolah_id);
        }

        // Summary Card Stats
        $totalSekolah = (clone $sekolahQuery)->count();
        $totalPegawai = (clone $pegawaiQuery)->count();

        $totalPns = (clone $pegawaiQuery)->where('status_kepegawaian', 'PNS')->count();
        $totalPppk = (clone $pegawaiQuery)->where('status_kepegawaian', 'PPPK')->count();
        $totalPppkPw = (clone $pegawaiQuery)->where('status_kepegawaian', 'PPPK PW')->count();
        $totalNonAsn = (clone $pegawaiQuery)->where('status_kepegawaian', 'Non-ASN')->count();

        // Kepala Sekolah Stats
        $totalDefinitif = (clone $sekolahQuery)->where('status_kepala_sekolah', 'Definitif')->count();
        $totalPlt = (clone $sekolahQuery)->where('status_kepala_sekolah', 'Plt')->count();
        $totalPlh = (clone $sekolahQuery)->where('status_kepala_sekolah', 'Plh')->count();

        // Scope operator count by role
        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
            $totalOperator = User::where('role', 'OPERATOR_SEKOLAH')->where('sekolah_id', $user->sekolah_id)->count();
        } else {
            $totalOperator = User::where('role', 'OPERATOR_SEKOLAH')->count();
        }

        // Chart 1: Top 7 Kecamatan by Total Schools
        $kecamatanStats = Sekolah::select('kecamatan', DB::raw('count(*) as total'))
            ->whereNotNull('kecamatan')
            ->where('kecamatan', '!=', '')
            ->groupBy('kecamatan')
            ->orderByDesc('total')
            ->limit(7)
            ->get();

        $kecamatanLabels = $kecamatanStats->pluck('kecamatan')->toArray();
        $kecamatanData = $kecamatanStats->pluck('total')->toArray();

        // Chart 2: Status Kepala Sekolah Breakdown
        $statusKepsekLabels = ['Definitif', 'Plt', 'Plh'];
        $statusKepsekData = [$totalDefinitif, $totalPlt, $totalPlh];

        // Recent Sekolahs & Recent Pegawais List
        $recentSekolahs = (clone $sekolahQuery)->withCount('pegawais')->with('users')->latest()->take(6)->get();
        $recentPegawais = (clone $pegawaiQuery)->with('sekolah')->latest()->take(6)->get();

        return view('dashboard', compact(
            'totalSekolah',
            'totalPegawai',
            'totalPns',
            'totalPppk',
            'totalPppkPw',
            'totalNonAsn',
            'totalDefinitif',
            'totalPlt',
            'totalPlh',
            'totalOperator',
            'kecamatanLabels',
            'kecamatanData',
            'statusKepsekLabels',
            'statusKepsekData',
            'recentSekolahs',
            'recentPegawais'
        ));
    }
}

