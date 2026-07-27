<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Sekolah;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /**
     * Display document verification queue for employees linked to schools.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Pegawai::whereNotNull('sekolah_id')->with(['sekolah', 'verifier']);

        // Scope query for Operator Sekolah
        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
            $query->where('sekolah_id', $user->sekolah_id);
        }

        // Search Filter (NIP, NIK, Nama Pegawai, Nama Sekolah)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nip_nik', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhereHas('sekolah', function ($qSekolah) use ($search) {
                      $qSekolah->where('nama_sekolah', 'like', "%{$search}%")
                               ->orWhere('npsn', 'like', "%{$search}%");
                  });
            });
        }

        // Status Verification Filter (DRAFT, MENUNGGU, REVISI, DISETUJUI)
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        // Sekolah Filter
        if ($request->filled('sekolah_id')) {
            $query->where('sekolah_id', $request->sekolah_id);
        }

        // Pagination
        $pegawais = $query->latest('updated_at')->paginate(15)->withQueryString();

        // Calculate Summary Metrics based on role
        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
            $sekolahId = $user->sekolah_id;
            $totalCount = Pegawai::where('sekolah_id', $sekolahId)->count();
            $menungguCount = Pegawai::where('sekolah_id', $sekolahId)->whereIn('status_verifikasi', ['MENUNGGU', 'DRAFT'])->count();
            $revisiCount = Pegawai::where('sekolah_id', $sekolahId)->where('status_verifikasi', 'REVISI')->count();
            $disetujuiCount = Pegawai::where('sekolah_id', $sekolahId)->where('status_verifikasi', 'DISETUJUI')->count();
            $sekolahs = collect(); // Operator doesn't need school list filter
        } else {
            $totalCount = Pegawai::whereNotNull('sekolah_id')->count();
            $menungguCount = Pegawai::whereNotNull('sekolah_id')->whereIn('status_verifikasi', ['MENUNGGU', 'DRAFT'])->count();
            $revisiCount = Pegawai::whereNotNull('sekolah_id')->where('status_verifikasi', 'REVISI')->count();
            $disetujuiCount = Pegawai::whereNotNull('sekolah_id')->where('status_verifikasi', 'DISETUJUI')->count();
            $sekolahs = Sekolah::orderBy('nama_sekolah')->get(['id', 'nama_sekolah', 'npsn']);
        }

        return view('verifikasi.index', compact(
            'pegawais',
            'sekolahs',
            'totalCount',
            'menungguCount',
            'revisiCount',
            'disetujuiCount'
        ));
    }

    /**
     * Show dedicated document review page for a specific employee.
     */
    public function show(Pegawai $pegawai)
    {
        $user = Auth::user();
        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
            if ($pegawai->sekolah_id !== $user->sekolah_id) {
                abort(403, 'Anda tidak memiliki akses untuk melihat berkas pegawai dari sekolah lain.');
            }
        }

        $pegawai->load(['sekolah', 'verifier']);
        return view('verifikasi.show', compact('pegawai'));
    }

    /**
     * Alias for show method to support /verifikasi/{pegawai}/tinjau route.
     */
    public function tinjau(Pegawai $pegawai)
    {
        return $this->show($pegawai);
    }

    /**
     * Update verification status & feedback notes.
     */
    public function updateStatus(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'status_verifikasi' => 'required|in:DRAFT,MENUNGGU,REVISI,DISETUJUI',
            'catatan_verifikasi' => 'nullable|string|max:1000',
        ]);

        if ($validated['status_verifikasi'] === 'REVISI' && empty(trim($validated['catatan_verifikasi'] ?? ''))) {
            return back()->withInput()->with('error', 'Harap berikan catatan revisi/perbaikan dokumen.');
        }

        $oldStatus = $pegawai->status_verifikasi ?? 'DRAFT';
        $newStatus = $validated['status_verifikasi'];

        $pegawai->update([
            'status_verifikasi' => $newStatus,
            'catatan_verifikasi' => $validated['catatan_verifikasi'] ?? null,
            'tgl_verifikasi' => now(),
            'verified_by' => Auth::id(),
        ]);

        // Log Activity
        ActivityLog::create([
            'loggable_type' => Pegawai::class,
            'loggable_id' => $pegawai->id,
            'user_id' => Auth::id(),
            'action' => 'VERIFIKASI_STATUS_UPDATE',
            'description' => "Memperbarui status verifikasi berkas {$pegawai->nama_lengkap} dari '{$oldStatus}' menjadi '{$newStatus}'",
            'payload' => json_encode([
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'catatan' => $validated['catatan_verifikasi'] ?? null,
            ]),
        ]);

        $statusText = [
            'DISETUJUI' => 'Disetujui & Valid',
            'REVISI' => 'Dikembalikan untuk Revisi',
            'MENUNGGU' => 'Menunggu Verifikasi',
            'DRAFT' => 'Draft / Belum Upload',
        ];

        return redirect()->route('verifikasi.index')->with('success', "Status verifikasi berkas {$pegawai->nama_lengkap} berhasil diperbarui menjadi: " . ($statusText[$newStatus] ?? $newStatus));
    }
}
