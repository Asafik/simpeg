<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SekolahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = Sekolah::withCount('pegawais')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                  ->orWhere('npsn', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('nama_kepala_sekolah', 'like', "%{$search}%");
            });
        }

        $sekolahs = $query->paginate(15)->withQueryString();

        return view('sekolah.index', compact('sekolahs', 'search'));
    }

    public function create()
    {
        return view('sekolah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'npsn' => 'required|string|max:20|unique:sekolahs,npsn',
            'nama_sekolah' => 'required|string|max:150',
            'kecamatan' => 'required|string|max:100',
            'nama_kepala_sekolah' => 'nullable|string|max:150',
            'nip_kepala_sekolah' => 'nullable|string|max:30',
            'status_kepala_sekolah' => 'required|in:Definitif,Plt,Plh',
            'email_sekolah' => 'nullable|email|max:100',
            'alamat' => 'nullable|string',
        ]);

        Sekolah::create($validated);

        return redirect()->route('sekolah.index')->with('success', 'Data Sekolah berhasil ditambahkan.');
    }

    public function show(Sekolah $sekolah)
    {
        $sekolah->load(['pegawais', 'users']);
        return view('sekolah.show', compact('sekolah'));
    }

    public function edit(Sekolah $sekolah)
    {
        return view('sekolah.edit', compact('sekolah'));
    }

    public function update(Request $request, Sekolah $sekolah)
    {
        $validated = $request->validate([
            'npsn' => ['required', 'string', 'max:20', Rule::unique('sekolahs')->ignore($sekolah->id)],
            'nama_sekolah' => 'required|string|max:150',
            'kecamatan' => 'required|string|max:100',
            'nama_kepala_sekolah' => 'nullable|string|max:150',
            'nip_kepala_sekolah' => 'nullable|string|max:30',
            'status_kepala_sekolah' => 'required|in:Definitif,Plt,Plh',
            'email_sekolah' => 'nullable|email|max:100',
            'alamat' => 'nullable|string',
        ]);

        $sekolah->update($validated);

        return redirect()->route('sekolah.index')->with('success', 'Data Sekolah berhasil diperbarui.');
    }

    public function destroy(Sekolah $sekolah)
    {
        $sekolah->delete();
        return redirect()->route('sekolah.index')->with('success', 'Data Sekolah berhasil dihapus.');
    }
}
