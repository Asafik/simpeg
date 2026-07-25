<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filters = $request->all();

        try {
            if (class_exists(Pegawai::class)) {
                $query = Pegawai::with('sekolah')->latest();

                // Operator sekolah restriction if user logged in
                if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah() && $user->sekolah_id) {
                    $filters['sekolah_id'] = $user->sekolah_id;
                }

                if (method_exists(Pegawai::class, 'scopeFilterKriteria')) {
                    $query->filterKriteria($filters);
                }

                $pegawais = $query->paginate(15)->withQueryString();
                $sekolahs = ($user && method_exists($user, 'isAdminDinas') && $user->isAdminDinas()) 
                    ? Sekolah::orderBy('nama_sekolah')->get() 
                    : collect();
                $kecamatans = Sekolah::distinct()->pluck('kecamatan')->sort()->values();

                $jabatanList = ['Guru Ahli Pertama', 'Guru Ahli Muda', 'Guru Ahli Madya', 'Guru Ahli Utama', 'Kepala Sekolah', 'Penilik', 'Staf Administrasi', 'Laboran', 'Pustakawan'];
                $jenisGuruList = ['Guru Kelas', 'Guru Mata Pelajaran', 'Guru BK', 'Guru Inklusi', 'Tidak Mengajar'];

                return view('pegawai.index', compact('pegawais', 'sekolahs', 'kecamatans', 'jabatanList', 'jenisGuruList', 'filters'));
            }
        } catch (\Throwable $e) {
            // Safe fallback for UI preview mode
        }

        return view('pegawai.index');
    }

    public function create()
    {
        $user = Auth::user();
        $sekolahs = collect();

        try {
            if (class_exists(Sekolah::class)) {
                if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
                    $sekolahs = Sekolah::where('id', $user->sekolah_id)->get();
                } else {
                    $sekolahs = Sekolah::orderBy('nama_sekolah')->get();
                }
            }
        } catch (\Throwable $e) {
            // Fallback
        }

        return view('pegawai.create', compact('sekolahs'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'nip_nik' => 'required|string|max:30|unique:pegawais,nip_nik',
            'nama_lengkap' => 'required|string|max:150',
            'status_kepegawaian' => 'required|in:PNS,PPPK,PPPK PW,Non-ASN',
            'jabatan_fungsional' => 'nullable|string|max:100',
            'is_serdik' => 'required|boolean',
            'jenis_ptk' => 'required|in:Pendidik,Tenaga Kependidikan',
            'jenis_guru' => 'nullable|string|max:100',
            'tingkat_pendidikan' => 'required|in:SMA/K,D3,S1/D4,S2,S3',
            'tanggal_lahir' => 'required|date',
            'file_sk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_serdik' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah() && $validated['sekolah_id'] != $user->sekolah_id) {
            return back()->withErrors(['sekolah_id' => 'Anda hanya dapat menambah pegawai di sekolah Anda sendiri.']);
        }

        // Upload files
        if ($request->hasFile('file_sk')) {
            $validated['file_sk'] = $request->file('file_sk')->store('berkas_pegawai/sk', 'public');
        }
        if ($request->hasFile('file_serdik')) {
            $validated['file_serdik'] = $request->file('file_serdik')->store('berkas_pegawai/serdik', 'public');
        }
        if ($request->hasFile('file_ijazah')) {
            $validated['file_ijazah'] = $request->file('file_ijazah')->store('berkas_pegawai/ijazah', 'public');
        }

        Pegawai::create($validated);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function show($id)
    {
        try {
            if (class_exists(Pegawai::class) && is_numeric($id)) {
                $pegawai = Pegawai::find($id);
                if ($pegawai) {
                    return view('pegawai.show', compact('pegawai'));
                }
            }
        } catch (\Throwable $e) {
            // Fallback
        }

        return view('pegawai.show');
    }

    public function edit($id)
    {
        return view('pegawai.create');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('pegawai.index');
    }

    public function destroy($id)
    {
        return redirect()->route('pegawai.index');
    }
}
