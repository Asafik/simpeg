<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

        $query = Sekolah::withCount('pegawais')->with('users')->latest();

        // 1. Laravel Eloquent Full-Text Search Filter (Smart Space-Insensitive Search)
        if (!empty($search)) {
            $cleanSearch = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($search));
            $query->where(function ($q) use ($search, $cleanSearch) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                  ->orWhereRaw("REPLACE(LOWER(nama_sekolah), ' ', '') LIKE ?", ["%{$cleanSearch}%"])
                  ->orWhere('npsn', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhereRaw("REPLACE(LOWER(kecamatan), ' ', '') LIKE ?", ["%{$cleanSearch}%"])
                  ->orWhere('nama_kepala_sekolah', 'like', "%{$search}%")
                  ->orWhereRaw("REPLACE(LOWER(nama_kepala_sekolah), ' ', '') LIKE ?", ["%{$cleanSearch}%"])
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

        $sekolah = Sekolah::create($validated);

        // Capture all field values for initial created log
        $allFields = [];
        foreach (['nama_sekolah','npsn','kecamatan','nama_kepala_sekolah','nip_kepala_sekolah','status_kepala_sekolah','email_sekolah','alamat'] as $f) {
            $val = $sekolah->$f;
            if (!is_null($val) && $val !== '') {
                $allFields[$f] = ['data' => (string)$val];
            }
        }
        ActivityLog::record($sekolah, 'created', $allFields, 'Satuan Pendidikan Pertama Kali Ditambahkan ke Sistem');

        // Auto-create operator account for this school
        $username = 'ops_' . $sekolah->npsn;
        $email = $sekolah->email_sekolah ?: ($username . '@dinas.sch.id');
        if (User::where('email', $email)->where('username', '!=', $username)->exists()) {
            $email = $username . '@dinas.sch.id';
        }

        User::updateOrCreate(
            ['username' => $username],
            [
                'name' => 'Operator ' . $sekolah->nama_sekolah,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'OPERATOR_SEKOLAH',
                'sekolah_id' => $sekolah->id,
            ]
        );

        return redirect()->route('sekolah.index')->with('success', "Satuan Pendidikan '{$sekolah->nama_sekolah}' dan akun Operator (username: {$username}) berhasil ditambahkan!");
    }

    /**
     * Display the specified school details.
     */
    public function show($id)
    {
        $sekolah = Sekolah::with('users', 'pegawais')->findOrFail($id);
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

        // Capture changes before update
        $trackableFields = ['npsn','nama_sekolah','kecamatan','nama_kepala_sekolah','nip_kepala_sekolah','status_kepala_sekolah','email_sekolah','alamat'];
        $changes = [];
        foreach ($trackableFields as $field) {
            $oldVal = $sekolah->getOriginal($field);
            $newVal = $validated[$field] ?? $sekolah->$field;
            if ((string)$oldVal !== (string)$newVal) {
                $changes[$field] = ['old' => $oldVal, 'new' => $newVal];
            }
        }

        $sekolah->update($validated);

        if (!empty($changes)) {
            ActivityLog::record($sekolah, 'updated', $changes, 'Edit Data Satuan Pendidikan');
        }

        // Sync associated operator username/email if changed
        $operator = User::where('sekolah_id', $sekolah->id)->first();
        if ($operator) {
            $operator->update([
                'name' => 'Operator ' . $sekolah->nama_sekolah,
                'email' => $sekolah->email_sekolah ?: $operator->email,
            ]);
        }

        return redirect()->route('sekolah.show', $sekolah->id)->with('success', 'Data Satuan Pendidikan berhasil diperbarui!');
    }

    /**
     * Remove the specified school from storage.
     */
    public function destroy($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $nama = $sekolah->nama_sekolah;

        // Delete associated user operator
        User::where('sekolah_id', $sekolah->id)->delete();
        $sekolah->delete();

        return redirect()->route('sekolah.index')->with('success', "Satuan Pendidikan '{$nama}' dan akun operator terkait berhasil dihapus!");
    }

    /**
     * Reset password for operator account associated with school.
     */
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
