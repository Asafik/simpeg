<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display listing of public announcements.
     */
    public function index()
    {
        return view('pengumuman.index');
    }

    /**
     * Show form for creating a new announcement.
     */
    public function create()
    {
        return view('pengumuman.create');
    }

    /**
     * Store a newly created announcement.
     */
    public function store(Request $request)
    {
        return redirect()->route('pengumuman.index')
            ->with('success', 'Pengumuman publik baru berhasil disimpan dan diterbitkan!');
    }

    /**
     * Show form for editing an existing announcement.
     */
    public function edit($id)
    {
        return view('pengumuman.create', ['isEdit' => true, 'id' => $id]);
    }

    /**
     * Update existing announcement.
     */
    public function update(Request $request, $id)
    {
        return redirect()->route('pengumuman.index')
            ->with('success', 'Pengumuman publik berhasil diperbarui!');
    }

    /**
     * Remove announcement.
     */
    public function destroy($id)
    {
        return redirect()->route('pengumuman.index')
            ->with('success', 'Pengumuman publik berhasil dihapus.');
    }
}
