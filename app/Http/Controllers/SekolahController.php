<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SekolahController extends Controller
{
    /**
     * Display a listing of schools with Laravel Eloquent search & multi-filter support.
     */
    public function index(Request $request)
    {
        // Robust parameter extractor to handle duplicate or empty query string values cleanly
        $getParam = function ($key) use ($request) {
            $val = $request->query($key);
            if (!empty($val)) {
                return is_string($val) ? trim($val) : $val;
            }
            // Fallback: search raw QUERY_STRING for any non-empty parameter for $key
            $rawQuery = $request->server('QUERY_STRING', '');
            if ($rawQuery) {
                foreach (explode('&', $rawQuery) as $pair) {
                    $parts = explode('=', $pair, 2);
                    if (count($parts) === 2 && urldecode($parts[0]) === $key && !empty(trim(urldecode($parts[1])))) {
                        return trim(urldecode($parts[1]));
                    }
                }
            }
            return null;
        };

        $search = $getParam('search') ?? '';
        $kecamatan = $getParam('kecamatan');
        $statusKepsek = $getParam('status_kepala_sekolah');
        $jenjang = $getParam('jenjang');

        $query = Sekolah::withCount('pegawais')->latest();

        // 1. Laravel Eloquent Full-Text Search Filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                  ->orWhere('npsn', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('nama_kepala_sekolah', 'like', "%{$search}%")
                  ->orWhere('nip_kepala_sekolah', 'like', "%{$search}%");
            });
        }

        // 2. Kecamatan Filter
        if (!empty($kecamatan)) {
            $query->where('kecamatan', $kecamatan);
        }

        // 3. Status Kepsek Filter
        if (!empty($statusKepsek)) {
            $query->where('status_kepala_sekolah', $statusKepsek);
        }

        // 4. Jenjang Sekolah Filter (Supports SD/SDN, SMP/SMPN, TK/TKN)
        if (!empty($jenjang)) {
            if ($jenjang === 'SD') {
                $query->where(function ($q) {
                    $q->where('nama_sekolah', 'like', 'SD%')
                      ->orWhere('nama_sekolah', 'like', '%SDN%');
                });
            } elseif ($jenjang === 'SMP') {
                $query->where(function ($q) {
                    $q->where('nama_sekolah', 'like', 'SMP%')
                      ->orWhere('nama_sekolah', 'like', '%SMPN%');
                });
            } elseif ($jenjang === 'TK') {
                $query->where(function ($q) {
                    $q->where('nama_sekolah', 'like', 'TK%')
                      ->orWhere('nama_sekolah', 'like', '%TKN%');
                });
            }
        }

        // Paginate results preserving all query parameters
        $sekolahs = $query->paginate(15)->appends(array_filter([
            'search' => $search,
            'kecamatan' => $kecamatan,
            'status_kepala_sekolah' => $statusKepsek,
            'jenjang' => $jenjang,
        ]));

        // Distinct list of kecamatan for the filter dropdown
        $listKecamatan = Sekolah::distinct()->pluck('kecamatan')->filter()->sort()->values();

        return view('sekolah.index', compact('sekolahs', 'search', 'kecamatan', 'statusKepsek', 'jenjang', 'listKecamatan'));
    }

    /**
     * Show the form for creating a new school.
     */
    public function create()
    {
        $sekolah = new Sekolah();
        $listKecamatan = Sekolah::distinct()->pluck('kecamatan')->filter()->sort()->values();
        return view('sekolah.create', compact('sekolah', 'listKecamatan'));
    }

    /**
     * Store a newly created school in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'npsn' => ['required', 'string', 'max:20', 'unique:sekolahs,npsn'],
            'nama_sekolah' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'email_sekolah' => ['nullable', 'email', 'max:255'],
            'nama_kepala_sekolah' => ['nullable', 'string', 'max:255'],
            'nip_kepala_sekolah' => ['nullable', 'string', 'max:50'],
            'status_kepala_sekolah' => ['required', 'string', Rule::in(['Definitif', 'Plt'])],
        ]);

        Sekolah::create($validated);

        return redirect()->route('sekolah.index')->with('success', 'Satuan Pendidikan baru berhasil ditambahkan!');
    }

    /**
     * Display the specified school details.
     */
    public function show($id)
    {
        $sekolah = Sekolah::with('pegawais')->findOrFail($id);
        return view('sekolah.show', compact('sekolah'));
    }

    /**
     * Show the form for editing the specified school.
     */
    public function edit($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $listKecamatan = Sekolah::distinct()->pluck('kecamatan')->filter()->sort()->values();
        return view('sekolah.create', compact('sekolah', 'listKecamatan'));
    }

    /**
     * Update the specified school in storage.
     */
    public function update(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);

        $validated = $request->validate([
            'npsn' => ['required', 'string', 'max:20', Rule::unique('sekolahs', 'npsn')->ignore($sekolah->id)],
            'nama_sekolah' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'email_sekolah' => ['nullable', 'email', 'max:255'],
            'nama_kepala_sekolah' => ['nullable', 'string', 'max:255'],
            'nip_kepala_sekolah' => ['nullable', 'string', 'max:50'],
            'status_kepala_sekolah' => ['required', 'string', Rule::in(['Definitif', 'Plt'])],
        ]);

        $sekolah->update($validated);

        return redirect()->route('sekolah.show', $sekolah->id)->with('success', 'Data Satuan Pendidikan berhasil diperbarui!');
    }

    /**
     * Remove the specified school from storage.
     */
    public function destroy($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $sekolah->delete();

        return redirect()->route('sekolah.index')->with('success', 'Data Satuan Pendidikan berhasil dihapus!');
    }
}
