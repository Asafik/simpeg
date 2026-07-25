<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the main SIMPEG-SP admin dashboard.
     */
    public function index(Request $request)
    {
        try {
            if (class_exists(\App\Models\Pegawai::class) && Auth::check()) {
                $user = Auth::user();
                $pegawaiQuery = \App\Models\Pegawai::query();
                $sekolahQuery = \App\Models\Sekolah::query();

                if (method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah() && $user->sekolah_id) {
                    $pegawaiQuery->where('sekolah_id', $user->sekolah_id);
                    $sekolahQuery->where('id', $user->sekolah_id);
                }

                $totalSekolah = $sekolahQuery->count();
                $totalPegawai = (clone $pegawaiQuery)->count();
                $totalPns = (clone $pegawaiQuery)->where('status_kepegawaian', 'PNS')->count();
                $totalPppk = (clone $pegawaiQuery)->where('status_kepegawaian', 'PPPK')->count();
                $totalPppkPw = (clone $pegawaiQuery)->where('status_kepegawaian', 'PPPK PW')->count();
                $totalNonAsn = (clone $pegawaiQuery)->where('status_kepegawaian', 'Non-ASN')->count();

                return view('dashboard', compact(
                    'totalSekolah', 'totalPegawai', 'totalPns', 'totalPppk', 'totalPppkPw', 'totalNonAsn'
                ));
            }
        } catch (\Throwable $e) {
            // DB not setup or fallback
        }

        return view('dashboard');
    }
}
