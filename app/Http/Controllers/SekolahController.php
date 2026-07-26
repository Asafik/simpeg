<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SekolahController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->query('search', ''));
        $kecamatanFilter = trim($request->query('kecamatan', ''));

        $query = Sekolah::withCount('pegawais')->with('users')->latest();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                  ->orWhere('npsn', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('nama_kepala_sekolah', 'like', "%{$search}%")
                  ->orWhere('nip_kepala_sekolah', 'like', "%{$search}%");
            });
        }

        if ($kecamatanFilter !== '') {
            $query->where('kecamatan', $kecamatanFilter);
        }

        $sekolahs = $query->paginate(15)->withQueryString();

        // Get unique kecamatan list for filter dropdown
        $listKecamatan = Sekolah::distinct()->pluck('kecamatan')->filter()->sort()->values();

        return view('sekolah.index', compact('sekolahs', 'search', 'kecamatanFilter', 'listKecamatan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'npsn' => 'required|string|max:20|unique:sekolahs,npsn',
            'nama_sekolah' => 'required|string|max:150',
            'kecamatan' => 'required|string|max:100',
            'nama_kepala_sekolah' => 'nullable|string|max:150',
            'nip_kepala_sekolah' => 'nullable|string|max:50',
            'status_kepala_sekolah' => 'nullable|string|in:Definitif,Plt,Plh',
            'email_sekolah' => 'nullable|email|max:100',
            'alamat' => 'nullable|string',
        ]);

        $sekolah = Sekolah::create($validated);

        // Auto-create operator account for this school
        $username = 'ops_' . $sekolah->npsn;
        User::updateOrCreate(
            ['username' => $username],
            [
                'name' => 'Operator ' . $sekolah->nama_sekolah,
                'email' => $sekolah->email_sekolah ?: ($username . '@dinas.sch.id'),
                'password' => Hash::make('password'),
                'role' => 'OPERATOR_SEKOLAH',
                'sekolah_id' => $sekolah->id,
            ]
        );

        return redirect()->route('sekolah.index')
            ->with('success', "Sekolah '{$sekolah->nama_sekolah}' dan akun Operator (username: {$username}) berhasil ditambahkan.");
    }

    public function show($id)
    {
        $sekolah = Sekolah::with('users', 'pegawais')->findOrFail($id);
        return response()->json($sekolah);
    }

    public function update(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);

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

        return redirect()->route('sekolah.index')
            ->with('success', "Data Sekolah '{$sekolah->nama_sekolah}' berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $nama = $sekolah->nama_sekolah;

        // Delete associated user operator
        User::where('sekolah_id', $sekolah->id)->delete();
        $sekolah->delete();

        return redirect()->route('sekolah.index')
            ->with('success', "Sekolah '{$nama}' dan akun operator terkait berhasil dihapus.");
    }

    public function resetPassword($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $operator = User::where('sekolah_id', $sekolah->id)->first();

        if (!$operator) {
            // Create if missing
            $username = 'ops_' . $sekolah->npsn;
            $operator = User::create([
                'username' => $username,
                'name' => 'Operator ' . $sekolah->nama_sekolah,
                'email' => $sekolah->email_sekolah ?: ($username . '@dinas.sch.id'),
                'password' => Hash::make('password'),
                'role' => 'OPERATOR_SEKOLAH',
                'sekolah_id' => $sekolah->id,
            ]);
        } else {
            $operator->update([
                'password' => Hash::make('password'),
            ]);
        }

        return redirect()->route('sekolah.index')
            ->with('success', "Password operator untuk '{$sekolah->nama_sekolah}' (Username: {$operator->username}) berhasil di-reset menjadi 'password'.");
    }
}

