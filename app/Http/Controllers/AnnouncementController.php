<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    /**
     * Helper to ensure only Admin Dinas can manage public announcements.
     */
    private function ensureAdminAccess()
    {
        $user = Auth::user();
        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak: Hanya Admin Dinas yang berhak mengelola Pengumuman Publik.');
        }
        return null;
    }

    /**
     * Display listing of public announcements (Admin Only Management).
     */
    public function index(Request $request)
    {
        if ($redirect = $this->ensureAdminAccess()) return $redirect;

        $search = $request->query('search');
        $kategori = $request->query('kategori');

        $query = Announcement::latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%")
                  ->orWhere('ringkasan', 'like', "%{$search}%");
            });
        }

        if (!empty($kategori)) {
            $query->where('kategori', $kategori);
        }

        $announcements = $query->paginate(10)->withQueryString();
        $totalAnnouncements = Announcement::count();

        return view('pengumuman.index', compact('announcements', 'totalAnnouncements', 'search', 'kategori'));
    }

    /**
     * Show form for creating a new announcement.
     */
    public function create()
    {
        if ($redirect = $this->ensureAdminAccess()) return $redirect;

        return view('pengumuman.create');
    }

    /**
     * Store a newly created announcement.
     */
    public function store(Request $request)
    {
        if ($redirect = $this->ensureAdminAccess()) return $redirect;

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'ringkasan' => 'nullable|string|max:500',
            'isi' => 'required|string',
            'is_published' => 'nullable|boolean',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,docx|max:10240',
        ], [
            'judul.required' => 'Judul pengumuman wajib diisi.',
            'kategori.required' => 'Kategori pengumuman wajib dipilih.',
            'isi.required' => 'Isi pengumuman wajib diisi.',
        ]);

        $user = Auth::user();
        $filePath = null;

        if ($request->hasFile('lampiran')) {
            $filePath = $request->file('lampiran')->store('pengumuman_files', 'public');
        }

        $announcement = Announcement::create([
            'judul' => trim($validated['judul']),
            'kategori' => $validated['kategori'],
            'ringkasan' => $validated['ringkasan'] ?? null,
            'isi' => $validated['isi'],
            'penulis_id' => $user?->id,
            'penulis_nama' => $user?->name ?? 'Admin Dinas Pendidikan',
            'is_published' => $request->has('is_published') ? (bool)$request->is_published : true,
            'lampiran_file' => $filePath,
        ]);

        ActivityLog::record($announcement, 'created', [], "Menerbitkan Pengumuman Publik: '{$announcement->judul}'");

        return redirect()->route('pengumuman.index')
            ->with('success', "Pengumuman publik '{$announcement->judul}' berhasil disimpan dan diterbitkan!");
    }

    /**
     * Show form for editing an existing announcement.
     */
    public function edit($id)
    {
        if ($redirect = $this->ensureAdminAccess()) return $redirect;

        $announcement = Announcement::findOrFail($id);
        return view('pengumuman.create', ['announcement' => $announcement, 'isEdit' => true, 'id' => $id]);
    }

    /**
     * Update existing announcement.
     */
    public function update(Request $request, $id)
    {
        if ($redirect = $this->ensureAdminAccess()) return $redirect;

        $announcement = Announcement::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'ringkasan' => 'nullable|string|max:500',
            'isi' => 'required|string',
            'is_published' => 'nullable|boolean',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,docx|max:10240',
        ], [
            'judul.required' => 'Judul pengumuman wajib diisi.',
            'kategori.required' => 'Kategori pengumuman wajib dipilih.',
            'isi.required' => 'Isi pengumuman wajib diisi.',
        ]);

        if ($request->hasFile('lampiran')) {
            if ($announcement->lampiran_file) {
                Storage::disk('public')->delete($announcement->lampiran_file);
            }
            $validated['lampiran_file'] = $request->file('lampiran')->store('pengumuman_files', 'public');
        }

        $validated['is_published'] = $request->has('is_published') ? (bool)$request->is_published : true;
        unset($validated['lampiran']);

        $announcement->update($validated);

        ActivityLog::record($announcement, 'updated', [], "Memperbarui Pengumuman Publik: '{$announcement->judul}'");

        return redirect()->route('pengumuman.index')
            ->with('success', "Pengumuman publik '{$announcement->judul}' berhasil diperbarui!");
    }

    /**
     * Remove announcement.
     */
    public function destroy($id)
    {
        if ($redirect = $this->ensureAdminAccess()) return $redirect;

        $announcement = Announcement::findOrFail($id);
        $title = $announcement->judul;

        if ($announcement->lampiran_file) {
            Storage::disk('public')->delete($announcement->lampiran_file);
        }

        ActivityLog::record($announcement, 'deleted', [], "Menghapus Pengumuman Publik: '{$title}'");
        $announcement->delete();

        return redirect()->route('pengumuman.index')
            ->with('success', "Pengumuman publik '{$title}' berhasil dihapus.");
    }
}
