<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OperatorVerifikasiController extends Controller
{
    /**
     * Display document verification and upload status for operator's school pegawais.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $sekolahId = $user->sekolah_id;

        $sekolah = $sekolahId ? Sekolah::find($sekolahId) : null;
        $statusFilter = $request->query('status', '');

        $query = Pegawai::query();
        if ($sekolahId) {
            $query->whereHas('sekolahs', fn($q) => $q->where('sekolahs.id', $sekolahId))->with('sekolahs')->latest();
        } else {
            $query->whereRaw('1 = 0');
        }

        if (in_array($statusFilter, ['Menunggu', 'Disetujui', 'Ditolak'])) {
            $query->where('status_verifikasi', $statusFilter);
        }

        $pegawais = $query->paginate(12)->withQueryString();

        // Calculate statistics for operator's school
        $baseQuery = Pegawai::whereHas('sekolahs', fn($q) => $q->where('sekolahs.id', $sekolahId));
        $totalPegawai = (clone $baseQuery)->count();
        $countMenunggu = (clone $baseQuery)->where('status_verifikasi', 'Menunggu')->count();
        $countDisetujui = (clone $baseQuery)->where('status_verifikasi', 'Disetujui')->count();
        $countDitolak = (clone $baseQuery)->where('status_verifikasi', 'Ditolak')->count();

        return view('operator.verifikasi.index', compact(
            'pegawais',
            'sekolah',
            'user',
            'statusFilter',
            'totalPegawai',
            'countMenunggu',
            'countDisetujui',
            'countDitolak'
        ));
    }

    /**
     * Upload or update verification documents (SK, Serdik, Ijazah) for a pegawai.
     */
    public function upload(Request $request, $id)
    {
        $user = Auth::user();
        $sekolahId = $user->sekolah_id;

        if (!$sekolahId) {
            return back()->with('error', 'Akun Anda belum terhubung ke Satuan Pendidikan manapun.');
        }

        $pegawai = Pegawai::whereHas('sekolahs', fn($q) => $q->where('sekolahs.id', $sekolahId))->findOrFail($id);

        $request->validate([
            'file_sk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_serdik' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $updated = false;

        if ($request->hasFile('file_sk')) {
            if (!empty($pegawai->file_sk)) Storage::disk('public')->delete($pegawai->file_sk);
            $pegawai->file_sk = [$request->file('file_sk')->store('berkas_pegawai/sk', 'public')];
            $updated = true;
        }

        if ($request->hasFile('file_serdik')) {
            if (!empty($pegawai->file_serdik)) Storage::disk('public')->delete($pegawai->file_serdik);
            $pegawai->file_serdik = [$request->file('file_serdik')->store('berkas_pegawai/serdik', 'public')];
            $updated = true;
        }

        if ($request->hasFile('file_ijazah')) {
            if (!empty($pegawai->file_ijazah)) Storage::disk('public')->delete($pegawai->file_ijazah);
            $pegawai->file_ijazah = [$request->file('file_ijazah')->store('berkas_pegawai/ijazah', 'public')];
            $updated = true;
        }

        if ($updated) {
            // Reset status to MENUNGGU and clear previous rejection note for re-verification
            $pegawai->status_verifikasi = 'MENUNGGU';
            $pegawai->catatan_verifikasi = null;
            $pegawai->save();

            return redirect()->route('operator.verifikasi.index')
                ->with('success', "Berkas dokumen atas nama '{$pegawai->nama_lengkap}' berhasil diunggah dan diajukan untuk verifikasi Admin Dinas.");
        }

        return redirect()->route('operator.verifikasi.index')
            ->with('info', 'Tidak ada berkas baru yang dipilih.');
    }
}
