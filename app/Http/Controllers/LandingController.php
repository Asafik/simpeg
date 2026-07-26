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

        return view('landing.pengumuman', compact('category'));
    }
}
