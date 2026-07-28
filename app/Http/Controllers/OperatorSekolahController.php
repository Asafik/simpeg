<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OperatorSekolahController extends Controller
{
    /**
     * Display the operator's school profile and details.
     */
    public function index()
    {
        $user = Auth::user();
        $sekolahId = $user->sekolah_id;

        $sekolah = $sekolahId ? Sekolah::withCount('pegawais')->with('users')->find($sekolahId) : null;

        $stats = [
            'totalPegawai' => 0,
            'pns' => 0,
            'pppk' => 0,
            'nonAsn' => 0,
        ];

        if ($sekolahId) {
            $pegawaiQuery = Pegawai::where('sekolah_id', $sekolahId);
            $stats['totalPegawai'] = (clone $pegawaiQuery)->count();
            $stats['pns'] = (clone $pegawaiQuery)->where('status_kepegawaian', 'PNS')->count();
            $stats['pppk'] = (clone $pegawaiQuery)->where('status_kepegawaian', 'like', 'PPPK%')->count();
            $stats['nonAsn'] = (clone $pegawaiQuery)->where('status_kepegawaian', 'Non-ASN')->count();
        }

        return view('operator.sekolah.index', compact('sekolah', 'user', 'stats'));
    }

    /**
     * Show the form for editing the operator's school profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $sekolahId = $user->sekolah_id;

        if (!$sekolahId) {
            return redirect()->route('operator.sekolah.index')
                ->with('error', 'Akun Anda belum terhubung ke Satuan Pendidikan manapun.');
        }

        $sekolah = Sekolah::findOrFail($sekolahId);

        return view('operator.sekolah.edit', compact('sekolah', 'user'));
    }

    /**
     * Update the operator's school profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $sekolahId = $user->sekolah_id;

        if (!$sekolahId) {
            return back()->with('error', 'Akun Anda belum terhubung ke Satuan Pendidikan manapun.');
        }

        $sekolah = Sekolah::findOrFail($sekolahId);

        $validated = $request->validate([
            'npsn' => ['required', 'string', 'max:20', Rule::unique('sekolahs')->ignore($sekolah->id)],
            'nama_sekolah' => 'required|string|max:150',
            'kecamatan' => 'required|string|max:100',
            'nama_kepala_sekolah' => 'nullable|string|max:150',
            'nip_kepala_sekolah' => 'nullable|string|max:50',
            'status_kepala_sekolah' => 'nullable|string|in:Definitif,Plt,Plh',
            'email_sekolah' => 'nullable|email|max:100',
            'alamat' => 'nullable|string',
        ]);

        $sekolah->update($validated);

        // Sync associated operator username/email if changed
        $operator = User::where('sekolah_id', $sekolah->id)->first();
        if ($operator) {
            $operator->update([
                'name' => 'Operator ' . $sekolah->nama_sekolah,
                'email' => $sekolah->email_sekolah ?: $operator->email,
            ]);
        }

        return redirect()->route('operator.sekolah.index')
            ->with('success', "Informasi Satuan Pendidikan '{$sekolah->nama_sekolah}' berhasil diperbarui.");
    }
}
