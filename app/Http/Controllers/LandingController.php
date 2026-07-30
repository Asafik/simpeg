<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display the main Landing Homepage.
     */
    public function index()
    {
        $totalSekolah = Sekolah::count();
        $totalPegawai = Pegawai::count();

        // Hitung persentase pegawai bersertifikasi (is_serdik = true)
        $totalSerdik = Pegawai::where('is_serdik', true)->count();
        $persenSerdik = $totalPegawai > 0 ? round(($totalSerdik / $totalPegawai) * 100) : 0;

        // Ambil 2 pengumuman terbaru yang dipublikasikan
        $latestAnnouncements = \App\Models\Announcement::where('is_published', true)
            ->latest()
            ->take(2)
            ->get();

        return view('landing.index', compact('totalSekolah', 'totalPegawai', 'persenSerdik', 'latestAnnouncements'));
    }

    /**
     * Display the Statistik Data Kepegawaian page.
     */
    public function statistik()
    {
        $totalSekolah = Sekolah::count();
        $totalPegawai = Pegawai::count();

        $totalPns = Pegawai::where('status_kepegawaian', 'PNS')->count();
        $totalPppk = Pegawai::where('status_kepegawaian', 'PPPK')->count();
        $totalPppkPw = Pegawai::where('status_kepegawaian', 'PPPK PW')->count();
        $totalNonAsn = Pegawai::where('status_kepegawaian', 'Non-ASN')->count();

        $totalSerdik = Pegawai::where('is_serdik', true)->count();
        $persenSerdik = $totalPegawai > 0 ? round(($totalSerdik / $totalPegawai) * 100, 1) : 0;

        // Hitung persentase untuk chart kriteria
        $persenPns = $totalPegawai > 0 ? round(($totalPns / $totalPegawai) * 100) : 0;
        $persenPppk = $totalPegawai > 0 ? round(($totalPppk / $totalPegawai) * 100) : 0;
        $persenPppkPw = $totalPegawai > 0 ? round(($totalPppkPw / $totalPegawai) * 100) : 0;
        $persenNonAsn = $totalPegawai > 0 ? round(($totalNonAsn / $totalPegawai) * 100) : 0;

        // Status Verifikasi Berkas
        $berkasValid = Pegawai::where('status_verifikasi', 'Disetujui')->count();
        $berkasPerbaikan = Pegawai::where('status_verifikasi', 'Ditolak')->count();

        return view('landing.statistik', compact(
            'totalSekolah',
            'totalPegawai',
            'totalPns',
            'totalPppk',
            'totalPppkPw',
            'totalNonAsn',
            'totalSerdik',
            'persenSerdik',
            'persenPns',
            'persenPppk',
            'persenPppkPw',
            'persenNonAsn',
            'berkasValid',
            'berkasPerbaikan'
        ));
    }

    /**
     * Display the Layanan & Keunggulan System page.
     */
    public function layanan()
    {
        $totalPegawai = Pegawai::count();
        $totalPns = Pegawai::where('status_kepegawaian', 'PNS')->count();
        $totalPppk = Pegawai::where('status_kepegawaian', 'PPPK')->count();
        $totalPppkPw = Pegawai::where('status_kepegawaian', 'PPPK PW')->count();

        $persenPns = $totalPegawai > 0 ? round(($totalPns / $totalPegawai) * 100) : 0;
        $persenPppk = $totalPegawai > 0 ? round(($totalPppk / $totalPegawai) * 100) : 0;
        $persenPppkPw = $totalPegawai > 0 ? round(($totalPppkPw / $totalPegawai) * 100) : 0;

        return view('landing.layanan', compact('persenPns', 'persenPppk', 'persenPppkPw'));
    }

    /**
     * Display the Cek Status Data PTK page with optional search filter.
     */
    public function cekPtk(Request $request)
    {
        $keyword = $request->query('keyword');
        $pegawai = null;

        if (!empty($keyword)) {
            $pegawai = Pegawai::with('sekolahs')
                ->where('nip', $keyword)
                ->orWhere('nik', $keyword)
                ->first();
        }

        return view('landing.cek-ptk', compact('keyword', 'pegawai'));
    }

    /**
     * Display the Pengumuman & Berita Kepegawaian page.
     */
    public function pengumuman(Request $request)
    {
        $category = $request->query('category', 'all');
        $search = $request->query('search');

        $query = \App\Models\Announcement::where('is_published', true)->latest();

        if ($category !== 'all' && !empty($category)) {
            $query->where('kategori', $category);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%")
                  ->orWhere('ringkasan', 'like', "%{$search}%");
            });
        }

        $announcements = $query->paginate(9)->withQueryString();

        return view('landing.pengumuman', compact('announcements', 'category', 'search'));
    }
}
