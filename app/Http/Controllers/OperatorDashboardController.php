<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorDashboardController extends Controller
{
    /**
     * Display the operator school dashboard.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $sekolah = null;
        if ($user && $user->sekolah_id) {
            $sekolah = Sekolah::find($user->sekolah_id);
        }

        $pegawaiQuery = Pegawai::query();
        if ($user && $user->sekolah_id) {
            $pegawaiQuery->whereHas('sekolahs', fn($q) => $q->where('sekolahs.id', $user->sekolah_id));
        } else {
            // Fallback if operator is not linked to any school yet
            $pegawaiQuery->whereRaw('1 = 0');
        }

        $totalPegawai = (clone $pegawaiQuery)->count();
        $totalPns = (clone $pegawaiQuery)->where('status_kepegawaian', 'PNS')->count();
        $totalPppk = (clone $pegawaiQuery)->where('status_kepegawaian', 'PPPK')->count();
        $totalPppkPw = (clone $pegawaiQuery)->where('status_kepegawaian', 'PPPK PW')->count();
        $totalNonAsn = (clone $pegawaiQuery)->where('status_kepegawaian', 'Non-ASN')->count();

        $recentPegawais = (clone $pegawaiQuery)->with('sekolahs')->latest()->take(10)->get();

        return view('operator.dashboard', compact(
            'user',
            'sekolah',
            'totalPegawai',
            'totalPns',
            'totalPppk',
            'totalPppkPw',
            'totalNonAsn',
            'recentPegawais'
        ));
    }
}
