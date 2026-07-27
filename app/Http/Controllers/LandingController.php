<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display the main Landing Homepage.
     */
    public function index()
    {
        return view('landing.index');
    }

    /**
     * Display the Statistik Data Kepegawaian page.
     */
    public function statistik()
    {
        return view('landing.statistik');
    }

    /**
     * Display the Layanan & Keunggulan System page.
     */
    public function layanan()
    {
        return view('landing.layanan');
    }

    /**
     * Display the Cek Status Data PTK page with optional search filter.
     */
    public function cekPtk(Request $request)
    {
        $keyword = $request->query('keyword');

        return view('landing.cek-ptk', compact('keyword'));
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
