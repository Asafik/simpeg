<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Sekolah;
use App\Models\ExcelImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OperatorPegawaiController extends Controller
{
    /**
     * Display a listing of pegawais scoped to the operator's school.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $sekolahId = $user->sekolah_id;

        $filters = $request->all();
        $filters['sekolah_id'] = $sekolahId;

        $sekolah = $sekolahId ? Sekolah::find($sekolahId) : null;

        $query = Pegawai::query();
        if ($sekolahId) {
            $query->whereHas('sekolahs', fn($q) => $q->where('sekolahs.id', $sekolahId))->with('sekolahs')->latest();
        } else {
            $query->whereRaw('1 = 0');
        }

        if (method_exists(Pegawai::class, 'scopeFilterKriteria')) {
            $query->filterKriteria($filters);
        }

        $pegawais = $query->paginate(15)->withQueryString();

        $jabatanList = ['Guru Ahli Pertama', 'Guru Ahli Muda', 'Guru Ahli Madya', 'Guru Ahli Utama', 'Kepala Sekolah', 'Penilik', 'Staf Administrasi', 'Laboran', 'Pustakawan'];
        $jenisGuruList = ['Guru Kelas', 'Guru Mata Pelajaran', 'Guru BK', 'Guru Inklusi', 'Tidak Mengajar'];

        return view('operator.pegawai.index', compact('pegawais', 'sekolah', 'jabatanList', 'jenisGuruList', 'filters'));
    }

    /**
     * Show the form for creating a new pegawai for the operator's school.
     */
    public function create()
    {
        $user = Auth::user();
        $sekolah = $user->sekolah_id ? Sekolah::find($user->sekolah_id) : null;

        return view('operator.pegawai.create', compact('sekolah'));
    }

    /**
     * Store a newly created pegawai for the operator's school.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $sekolahId = $user->sekolah_id;

        if (!$sekolahId) {
            return back()->withErrors(['sekolah_id' => 'Akun operator Anda belum terhubung dengan Sekolah manapun.']);
        }

        $validated = $request->validate([
            'nip_nik' => 'nullable|string|max:30',
            'nik' => 'nullable|string|max:30',
            'nama_lengkap' => 'required|string|max:150',
            'status_kepegawaian' => 'required|in:PNS,PPPK,PPPK PW,Non-ASN',
            'pangkat_golongan' => 'nullable|string|max:50',
            'jabatan_fungsional' => 'nullable|string|max:100',
            'no_sk_jabfung' => 'nullable|string|max:100',
            'tmt_jabfung' => 'nullable|string|max:50',
            'is_serdik' => 'required|boolean',
            'no_serdik' => 'nullable|string|max:100',
            'tgl_serdik' => 'nullable|string|max:50',
            'jenis_ptk' => 'required|in:Pendidik,Tenaga Kependidikan',
            'jenis_guru' => 'nullable|string|max:100',
            'jumlah_jp' => 'nullable|string|max:30',
            'nuptk' => 'nullable|string|max:30',
            'tingkat_pendidikan' => 'required|in:SMA/K,D3,S1/D4,S2,S3',
            'jurusan_prodi' => 'nullable|string|max:150',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'nullable|in:Laki-Laki,Perempuan',
            'agama' => 'nullable|string|max:50',
            'file_sk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_serdik' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        unset($validated['sekolah_id']);

        // Upload files
        $hasUpload = false;
        if ($request->hasFile('file_sk')) {
            $validated['file_sk'] = [$request->file('file_sk')->store('berkas_pegawai/sk', 'public')];
            $hasUpload = true;
        }
        if ($request->hasFile('file_serdik')) {
            $validated['file_serdik'] = [$request->file('file_serdik')->store('berkas_pegawai/serdik', 'public')];
            $hasUpload = true;
        }
        if ($request->hasFile('file_ijazah')) {
            $validated['file_ijazah'] = [$request->file('file_ijazah')->store('berkas_pegawai/ijazah', 'public')];
            $hasUpload = true;
        }
        if ($hasUpload) {
            $validated['status_verifikasi'] = 'MENUNGGU';
        }

        $pegawai = Pegawai::create($validated);
        if ($sekolahId) {
            $pegawai->sekolahs()->attach($sekolahId, ['is_primary' => true]);
        }

        return redirect()->route('operator.pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    /**
     * Display the specified pegawai details.
     */
    public function show($id)
    {
        $user = Auth::user();
        $pegawai = Pegawai::whereHas('sekolahs', fn($q) => $q->where('sekolahs.id', $user->sekolah_id))->with('sekolahs')->findOrFail($id);

        return view('operator.pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified pegawai.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $pegawai = Pegawai::whereHas('sekolahs', fn($q) => $q->where('sekolahs.id', $user->sekolah_id))->findOrFail($id);
        $sekolah = Sekolah::find($user->sekolah_id);

        return view('operator.pegawai.edit', compact('pegawai', 'sekolah'));
    }

    /**
     * Update the specified pegawai in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $pegawai = Pegawai::whereHas('sekolahs', fn($q) => $q->where('sekolahs.id', $user->sekolah_id))->findOrFail($id);

        $validated = $request->validate([
            'nip_nik' => 'nullable|string|max:30',
            'nik' => 'nullable|string|max:30',
            'nama_lengkap' => 'required|string|max:150',
            'status_kepegawaian' => 'required|in:PNS,PPPK,PPPK PW,Non-ASN',
            'pangkat_golongan' => 'nullable|string|max:50',
            'jabatan_fungsional' => 'nullable|string|max:100',
            'no_sk_jabfung' => 'nullable|string|max:100',
            'tmt_jabfung' => 'nullable|string|max:50',
            'is_serdik' => 'required|boolean',
            'no_serdik' => 'nullable|string|max:100',
            'tgl_serdik' => 'nullable|string|max:50',
            'jenis_ptk' => 'required|in:Pendidik,Tenaga Kependidikan',
            'jenis_guru' => 'nullable|string|max:100',
            'jumlah_jp' => 'nullable|string|max:30',
            'nuptk' => 'nullable|string|max:30',
            'tingkat_pendidikan' => 'required|in:SMA/K,D3,S1/D4,S2,S3',
            'jurusan_prodi' => 'nullable|string|max:150',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'nullable|in:Laki-Laki,Perempuan',
            'agama' => 'nullable|string|max:50',
            'file_sk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_serdik' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        unset($validated['sekolah_id']);

        $hasUpload = false;
        if ($request->hasFile('file_sk')) {
            if (!empty($pegawai->file_sk)) Storage::disk('public')->delete($pegawai->file_sk);
            $validated['file_sk'] = [$request->file('file_sk')->store('berkas_pegawai/sk', 'public')];
            $hasUpload = true;
        }
        if ($request->hasFile('file_serdik')) {
            if (!empty($pegawai->file_serdik)) Storage::disk('public')->delete($pegawai->file_serdik);
            $validated['file_serdik'] = [$request->file('file_serdik')->store('berkas_pegawai/serdik', 'public')];
            $hasUpload = true;
        }
        if ($request->hasFile('file_ijazah')) {
            if (!empty($pegawai->file_ijazah)) Storage::disk('public')->delete($pegawai->file_ijazah);
            $validated['file_ijazah'] = [$request->file('file_ijazah')->store('berkas_pegawai/ijazah', 'public')];
            $hasUpload = true;
        }
        if ($hasUpload) {
            $validated['status_verifikasi'] = 'MENUNGGU';
            $validated['catatan_verifikasi'] = null;
        }

        $pegawai->update($validated);
        if ($user->sekolah_id) {
            $pegawai->sekolahs()->sync([$user->sekolah_id => ['is_primary' => true]]);
        }

        return redirect()->route('operator.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified pegawai from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $pegawai = Pegawai::whereHas('sekolahs', fn($q) => $q->where('sekolahs.id', $user->sekolah_id))->findOrFail($id);

        if ($pegawai->file_sk) Storage::disk('public')->delete($pegawai->file_sk);
        if ($pegawai->file_serdik) Storage::disk('public')->delete($pegawai->file_serdik);
        if ($pegawai->file_ijazah) Storage::disk('public')->delete($pegawai->file_ijazah);

        $pegawai->delete();

        return redirect()->route('operator.pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }

    /**
     * Bulk destroy pegawais in operator's school.
     */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids) || !is_array($ids)) {
            return back()->with('error', 'Pilih minimal satu data pegawai untuk dihapus.');
        }

        $user = Auth::user();
        $pegawais = Pegawai::whereIn('id', $ids)->whereHas('sekolahs', fn($q) => $q->where('sekolahs.id', $user->sekolah_id))->get();
        $deletedCount = 0;

        foreach ($pegawais as $pegawai) {
            if ($pegawai->file_sk) Storage::disk('public')->delete($pegawai->file_sk);
            if ($pegawai->file_serdik) Storage::disk('public')->delete($pegawai->file_serdik);
            if ($pegawai->file_ijazah) Storage::disk('public')->delete($pegawai->file_ijazah);

            $pegawai->delete();
            $deletedCount++;
        }

        return redirect()->route('operator.pegawai.index')->with('success', "Berhasil menghapus {$deletedCount} data pegawai.");
    }
}
