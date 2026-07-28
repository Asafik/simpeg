<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /**
     * Display document verification queue (SK, Serdik, Ijazah).
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Redirect Operator Sekolah to their dedicated verifikasi upload page
        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
            return redirect()->route('operator.verifikasi.index');
        }

        $status = $request->query('status', 'Menunggu');

        $query = Pegawai::with('sekolah')
            ->where(function ($q) {
                $q->whereNotNull('file_sk')
                  ->orWhereNotNull('file_serdik')
                  ->orWhereNotNull('file_ijazah');
            });

        // Scope to user's school if Operator Sekolah
        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
            if ($user->sekolah_id) {
                $query->where('sekolah_id', $user->sekolah_id);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        if (in_array($status, ['Menunggu', 'Disetujui', 'Ditolak'])) {
            $query->where('status_verifikasi', $status);
        }

        $pegawais = $query->latest()->paginate(12)->withQueryString();

        // Calculate counts
        $baseQuery = Pegawai::where(function ($q) {
            $q->whereNotNull('file_sk')
              ->orWhereNotNull('file_serdik')
              ->orWhereNotNull('file_ijazah');
        });

        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
            if ($user->sekolah_id) {
                $baseQuery->where('sekolah_id', $user->sekolah_id);
            } else {
                $baseQuery->whereRaw('1 = 0');
            }
        }

        $countMenunggu = (clone $baseQuery)->where('status_verifikasi', 'Menunggu')->count();
        $countDisetujui = (clone $baseQuery)->where('status_verifikasi', 'Disetujui')->count();
        $countDitolak = (clone $baseQuery)->where('status_verifikasi', 'Ditolak')->count();

        return view('verifikasi.index', compact(
            'pegawais',
            'status',
            'countMenunggu',
            'countDisetujui',
            'countDitolak',
            'user'
        ));
    }

    /**
     * Process verification approval or rejection (Strictly Admin Dinas).
     */
    public function verify(Request $request, $id)
    {
        $user = Auth::user();

        // Enforce strict Admin Dinas check
        if (!$user || !method_exists($user, 'isAdminDinas') || !$user->isAdminDinas()) {
            abort(403, 'Akses Ditolak: Hanya Administrator Dinas yang berhak memverifikasi atau menolak berkas.');
        }

        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'catatan' => 'nullable|string|max:500',
        ]);

        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update([
            'status_verifikasi' => $request->status,
            'catatan_verifikasi' => $request->catatan,
        ]);

        $msg = $request->status === 'Disetujui' 
            ? "Berkas dokumen atas nama '{$pegawai->nama_lengkap}' berhasil disetujui."
            : "Berkas dokumen atas nama '{$pegawai->nama_lengkap}' ditolak dengan catatan.";

        return back()->with('success', $msg);
    }
}
