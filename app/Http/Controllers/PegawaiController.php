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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\ActivityLog;

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

                // Scope counts by user role
                if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah() && $user->sekolah_id) {
                    $sekolahId = $user->sekolah_id;
                    $totalPegawaiCount = Pegawai::where('sekolah_id', $sekolahId)->count();
                    $totalPnsCount     = Pegawai::where('sekolah_id', $sekolahId)->where('status_kepegawaian', 'PNS')->count();
                    $totalPppkCount    = Pegawai::where('sekolah_id', $sekolahId)->whereIn('status_kepegawaian', ['PPPK', 'PPPK PW'])->count();
                    $totalSerdikCount  = Pegawai::where('sekolah_id', $sekolahId)->where('is_serdik', true)->count();
                } else {
                    $totalPegawaiCount = Pegawai::count();
                    $totalPnsCount     = Pegawai::where('status_kepegawaian', 'PNS')->count();
                    $totalPppkCount    = Pegawai::whereIn('status_kepegawaian', ['PPPK', 'PPPK PW'])->count();
                    $totalSerdikCount  = Pegawai::where('is_serdik', true)->count();
                }

                $sekolahs = ($user && method_exists($user, 'isAdminDinas') && $user->isAdminDinas())
                    ? Sekolah::orderBy('nama_sekolah')->get()
                    : collect();
                $kecamatans = Sekolah::distinct()->pluck('kecamatan')->sort()->values();

                $jabatanList = ['Guru Ahli Pertama', 'Guru Ahli Muda', 'Guru Ahli Madya', 'Guru Ahli Utama', 'Kepala Sekolah', 'Penilik', 'Staf Administrasi', 'Laboran', 'Pustakawan'];
                $jenisGuruList = ['Guru Kelas', 'Guru Mata Pelajaran', 'Guru BK', 'Guru Inklusi', 'Tidak Mengajar'];

                return view('pegawai.index', compact('pegawais', 'sekolahs', 'kecamatans', 'jabatanList', 'jenisGuruList', 'filters', 'totalPegawaiCount', 'totalPnsCount', 'totalPppkCount', 'totalSerdikCount'));
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
            'file_sk' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:20480',
            'file_serdik' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:20480',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:20480',
        ], [
            'file_sk.max' => 'Ukuran berkas SK Kepegawaian tidak boleh melebihi 20 MB.',
            'file_sk.mimes' => 'Format berkas SK Kepegawaian harus PDF, JPG, JPEG, PNG, atau WEBP.',
            'file_serdik.max' => 'Ukuran berkas Sertifikat Pendidik tidak boleh melebihi 20 MB.',
            'file_serdik.mimes' => 'Format berkas Sertifikat Pendidik harus PDF, JPG, JPEG, PNG, atau WEBP.',
            'file_ijazah.max' => 'Ukuran berkas Ijazah tidak boleh melebihi 20 MB.',
            'file_ijazah.mimes' => 'Format berkas Ijazah harus PDF, JPG, JPEG, PNG, atau WEBP.',
        ]);

        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah() && $validated['sekolah_id'] != $user->sekolah_id) {
            return back()->withErrors(['sekolah_id' => 'Anda hanya dapat menambah pegawai di sekolah Anda sendiri.']);
        }

        // Upload files
        $hasUpload = false;
        if ($request->hasFile('file_sk')) {
            $validated['file_sk'] = $request->file('file_sk')->store('berkas_pegawai/sk', 'public');
            $hasUpload = true;
        }
        if ($request->hasFile('file_serdik')) {
            $validated['file_serdik'] = $request->file('file_serdik')->store('berkas_pegawai/serdik', 'public');
            $hasUpload = true;
        }
        if ($request->hasFile('file_ijazah')) {
            $validated['file_ijazah'] = $request->file('file_ijazah')->store('berkas_pegawai/ijazah', 'public');
            $hasUpload = true;
        }
        if ($hasUpload) {
            $validated['status_verifikasi'] = 'MENUNGGU';
        }

        $pegawai = Pegawai::create($validated);

        // Capture all field values for initial created log
        $allFields = [];
        foreach (['nama_lengkap','nip_nik','nik','status_kepegawaian','pangkat_golongan','jabatan_fungsional','no_sk_jabfung','tmt_jabfung','is_serdik','no_serdik','tgl_serdik','jenis_ptk','jenis_guru','jumlah_jp','nuptk','tingkat_pendidikan','jurusan_prodi','tempat_lahir','tanggal_lahir','jenis_kelamin','agama','sekolah_id'] as $f) {
            $val = $pegawai->$f;
            if (!is_null($val) && $val !== '') {
                $allFields[$f] = ['data' => ($val === true ? 'Ya' : ($val === false ? 'Tidak' : (string)$val))];
            }
        }
        ActivityLog::record($pegawai, 'created', $allFields, 'Data Pegawai Pertama Kali Ditambahkan (Manual)');

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function show($id)
    {
        try {
            if (class_exists(Pegawai::class) && is_numeric($id)) {
                $pegawai = Pegawai::with('sekolah')->find($id);
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
        $pegawai = Pegawai::findOrFail($id);
        $user = Auth::user();
        $sekolahs = ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah())
            ? Sekolah::where('id', $user->sekolah_id)->get()
            : Sekolah::orderBy('nama_sekolah')->get();

        return view('pegawai.create', compact('pegawai', 'sekolahs'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $user = Auth::user();

        $validated = $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
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
            'file_sk' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:20480',
            'file_serdik' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:20480',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:20480',
        ], [
            'file_sk.max' => 'Ukuran berkas SK Kepegawaian tidak boleh melebihi 20 MB.',
            'file_sk.mimes' => 'Format berkas SK Kepegawaian harus PDF, JPG, JPEG, PNG, atau WEBP.',
            'file_serdik.max' => 'Ukuran berkas Sertifikat Pendidik tidak boleh melebihi 20 MB.',
            'file_serdik.mimes' => 'Format berkas Sertifikat Pendidik harus PDF, JPG, JPEG, PNG, atau WEBP.',
            'file_ijazah.max' => 'Ukuran berkas Ijazah tidak boleh melebihi 20 MB.',
            'file_ijazah.mimes' => 'Format berkas Ijazah harus PDF, JPG, JPEG, PNG, atau WEBP.',
        ]);

        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah() && $validated['sekolah_id'] != $user->sekolah_id) {
            return back()->withErrors(['sekolah_id' => 'Anda hanya dapat memperbarui data di sekolah Anda sendiri.']);
        }

        $hasUpload = false;
        if ($request->hasFile('file_sk')) {
            if ($pegawai->file_sk) Storage::disk('public')->delete($pegawai->file_sk);
            $validated['file_sk'] = $request->file('file_sk')->store('berkas_pegawai/sk', 'public');
            $hasUpload = true;
        }
        if ($request->hasFile('file_serdik')) {
            if ($pegawai->file_serdik) Storage::disk('public')->delete($pegawai->file_serdik);
            $validated['file_serdik'] = $request->file('file_serdik')->store('berkas_pegawai/serdik', 'public');
            $hasUpload = true;
        }
        if ($request->hasFile('file_ijazah')) {
            if ($pegawai->file_ijazah) Storage::disk('public')->delete($pegawai->file_ijazah);
            $validated['file_ijazah'] = $request->file('file_ijazah')->store('berkas_pegawai/ijazah', 'public');
            $hasUpload = true;
        }
        if ($hasUpload && ($pegawai->status_verifikasi === 'DRAFT' || $pegawai->status_verifikasi === 'REVISI')) {
            $validated['status_verifikasi'] = 'MENUNGGU';
        }

        // Capture changes before update
        $trackableFields = ['nama_lengkap','nip_nik','nik','status_kepegawaian','pangkat_golongan','jabatan_fungsional','no_sk_jabfung','tmt_jabfung','is_serdik','no_serdik','tgl_serdik','jenis_ptk','jenis_guru','jumlah_jp','nuptk','tingkat_pendidikan','jurusan_prodi','tempat_lahir','tanggal_lahir','jenis_kelamin','agama','sekolah_id'];
        $changes = [];
        foreach ($trackableFields as $field) {
            $oldVal = $pegawai->getOriginal($field);
            $newVal = $validated[$field] ?? $pegawai->$field;
            if ((string)$oldVal !== (string)$newVal) {
                $changes[$field] = ['old' => $oldVal, 'new' => $newVal];
            }
        }

        $pegawai->update($validated);

        if (!empty($changes)) {
            ActivityLog::record($pegawai, 'updated', $changes, 'Edit Data Pegawai');
        }

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $user = Auth::user();

        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah() && $pegawai->sekolah_id != $user->sekolah_id) {
            return back()->with('error', 'Anda tidak memiliki hak akses untuk menghapus pegawai ini.');
        }

        if ($pegawai->file_sk) Storage::disk('public')->delete($pegawai->file_sk);
        if ($pegawai->file_serdik) Storage::disk('public')->delete($pegawai->file_serdik);
        if ($pegawai->file_ijazah) Storage::disk('public')->delete($pegawai->file_ijazah);

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids) || !is_array($ids)) {
            return back()->with('error', 'Pilih minimal satu data pegawai untuk dihapus.');
        }

        $user = Auth::user();
        $query = Pegawai::whereIn('id', $ids);

        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah() && $user->sekolah_id) {
            $query->where('sekolah_id', $user->sekolah_id);
        }

        $pegawais = $query->get();
        $deletedCount = 0;

        foreach ($pegawais as $pegawai) {
            if ($pegawai->file_sk) Storage::disk('public')->delete($pegawai->file_sk);
            if ($pegawai->file_serdik) Storage::disk('public')->delete($pegawai->file_serdik);
            if ($pegawai->file_ijazah) Storage::disk('public')->delete($pegawai->file_ijazah);

            $pegawai->delete();
            $deletedCount++;
        }

        return redirect()->route('pegawai.index')->with('success', "Berhasil menghapus {$deletedCount} data pegawai.");
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();

        // --- Sheet 1: Form Data Pegawai ---
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Form SDN');

        // Banner Title Block (Rows 2-5)
        $sheet->setCellValue('B2', 'DATA PEGAWAI ASN (PNS, PPPK, PPPK PARUH WAKTU) & NON-ASN');
        $sheet->setCellValue('B3', 'DI UNIT PELAKSANA TUGAS DAERAH (UPTD) SATUAN PENDIDIKAN DINAS PENDIDIKAN');
        $sheet->setCellValue('B4', 'TAHUN 2026');

        $sheet->getStyle('B2:B4')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('B2')->getFont()->setSize(12);

        // Notes (Rows 7-9)
        $sheet->setCellValue('B7', 'Catatan:');
        $sheet->setCellValue('B8', '1. Harap diisi sesuai data pegawai pada satuan pendidikan masing-masing');
        $sheet->setCellValue('B9', '2. Isilah kolom status kepegawaian, serdik, jenis PTK, & pendidikan sesuai daftar pilihan');
        $sheet->getStyle('B7:B9')->getFont()->setItalic(true)->setSize(9)->getColor()->setARGB('FF555555');

        // Row 11: Main Group Headers
        $sheet->setCellValue('A11', 'NO');
        $sheet->setCellValue('B11', 'DATA KEPEGAWAIAN');
        $sheet->setCellValue('D11', 'STATUS KEPEGAWAIAN SAAT INI');
        $sheet->setCellValue('F11', 'DATA JABFUNG TERAKHIR');
        $sheet->setCellValue('I11', 'SERDIK / NON SERDIK');
        $sheet->setCellValue('L11', 'Jenis PTK');
        $sheet->setCellValue('M11', 'Jenis Guru (Khusus Jenis PTK Guru)');
        $sheet->setCellValue('N11', 'Jumlah JP');
        $sheet->setCellValue('O11', 'NUPTK');
        $sheet->setCellValue('P11', 'PENDIDIKAN TERAKHIR');
        $sheet->setCellValue('R11', 'DATA PENDUKUNG');
        $sheet->setCellValue('W11', 'LEMBAGA SEKOLAH');

        // Merge Row 11 Groups
        $sheet->mergeCells('B11:C11');
        $sheet->mergeCells('D11:E11');
        $sheet->mergeCells('F11:H11');
        $sheet->mergeCells('I11:K11');
        $sheet->mergeCells('P11:Q11');
        $sheet->mergeCells('R11:V11');
        $sheet->mergeCells('W11:Y11');

        // Row 12: Sub-Headers (Official Columns 1-25)
        $headersRow12 = [
            'NO',
            'NAMA PEGAWAI (Dengan Gelar)',
            'NIP (tanpa spasi)',
            'STATUS KEPEGAWAIAN (Pilih Salah Satu)',
            'PANGKAT / GOL.',
            'JABATAN FUNGSIONAL (PNS DAN PPPK)',
            'NO. SK JABFUNG',
            'TMT JABFUNG',
            'Serdik / Non Serdik (Pilih Salah Satu)',
            'Nomor Serdik',
            'Tanggal Serdik',
            'Jenis PTK',
            'Jenis Guru (Khusus Jenis PTK Guru)',
            'Jumlah JP',
            'NUPTK',
            'TINGKAT PENDIDIKAN',
            'JURUSAN/PROGRAM STUDI',
            'NIK',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR (DD/MM/YYYY)',
            'JENIS KELAMIN (L/P)',
            'AGAMA',
            'Nama Sekolah',
            'NPSN',
            'Kecamatan Sekolah'
        ];

        foreach ($headersRow12 as $idx => $header) {
            $colLetter = Coordinate::stringFromColumnIndex($idx + 1);
            $sheet->setCellValue("{$colLetter}12", $header);
            $sheet->setCellValue("{$colLetter}13", $idx + 1); // Column numbers 1-25
        }

        // Style Header Rows (11-13)
        $sheet->getStyle('A11:Y13')->getFont()->setBold(true)->setSize(9);
        $sheet->getStyle('A11:Y13')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A11:Y13')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // Header colors
        $sheet->getStyle('A11:Y13')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E3A8A'); // Dark Blue
        $sheet->getStyle('A11:Y13')->getFont()->getColor()->setARGB('FFFFFFFF'); // White text

        // Sample Data Rows (Row 14-16)
        $samples = [
            [
                1, 'DIYANDIKA ANGGRAENI, S.Pd', '198912092025212030', 'PPPK', 'X', 'Guru Ahli Pertama', '', '',
                'SERDIK', '0010302202720097', '15/09/2022', 'Guru Kelas', 'Guru Kelas', '32 JP', '',
                'Strata 1 (S1)', 'Pendidikan Matematika', '3509264912890003', 'JEMBER', '09/12/1982',
                'Perempuan', 'Islam', 'SDN SEPUTIH 03', '20523357', 'MAYANG'
            ],
            [
                2, 'UYAYYNAH, S.Pd', '199307312025212108', 'PPPK Paruh Waktu', '-', '-', '', '',
                'SERDIK', '0010258690424027', '10/01/2023', 'Guru Kelas', 'Guru Kelas', '32 JP', '',
                'Strata 1 (S1)', 'PGSD', '3509267107930001', 'JEMBER', '31/07/1993',
                'Perempuan', 'Islam', 'SDN SEPUTIH 03', '20523357', 'MAYANG'
            ],
            [
                3, 'RUSLI EFENDI', '199202142025211063', 'Non ASN', '-', '-', '', '',
                'NON SERDIK', '', '', 'Tenaga Kependidikan', 'Tenaga Kependidikan', '', '',
                'SMA/Sederajat', '', '3509261402920002', 'JEMBER', '14/02/1992',
                'Laki-Laki', 'Islam', 'SDN SEPUTIH 03', '20523357', 'MAYANG'
            ]
        ];

        foreach ($samples as $rIdx => $rowValues) {
            $rowNum = 14 + $rIdx;
            foreach ($rowValues as $cIdx => $val) {
                $colLetter = Coordinate::stringFromColumnIndex($cIdx + 1);
                $sheet->setCellValueExplicit("{$colLetter}{$rowNum}", (string)$val, DataType::TYPE_STRING);
            }
        }

        // Auto-fit column widths
        foreach (range(1, 25) as $colIdx) {
            $colLetter = Coordinate::stringFromColumnIndex($colIdx);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        // --- Sheet 2: Referensi Data ---
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Sheet2');

        $refHeaders = ['No', 'Status Kepegawaian', '', 'SERDIK/NON SERDIK', '', 'Jenis Kelamin', '', 'Agama', '', 'Jabatan Fungsional', '', 'Pendidikan Terakhir', '', 'Jenis PTK'];
        foreach ($refHeaders as $cIdx => $h) {
            if ($h) {
                $colLetter = Coordinate::stringFromColumnIndex($cIdx + 1);
                $sheet2->setCellValue("{$colLetter}3", $h);
            }
        }

        $refData = [
            ['1', 'PNS', '', 'SERDIK', '', 'Laki-Laki', '', 'Islam', '', 'Guru Ahli Pertama', '', 'SD/Sederajat', '', 'Kepala Sekolah'],
            ['2', 'PPPK', '', 'NON SERDIK', '', 'Perempuan', '', 'Kristen', '', 'Guru Ahli Muda', '', 'SMP/Sederajat', '', 'Guru Kelas'],
            ['3', 'PPPK Paruh Waktu', '', '', '', '', '', 'Katolik', '', 'Guru Ahli Madya', '', 'SMA/Sederajat', '', 'Guru Mapel'],
            ['4', 'Non ASN', '', '', '', '', '', 'Hindu', '', 'Guru Ahli Utama', '', 'Diploma 3', '', 'Tenaga Kependidikan'],
            ['5', '', '', '', '', '', '', 'Budha', '', '-', '', 'Strata 1 (S1)', '', ''],
            ['6', '', '', '', '', '', '', 'Lainnya', '', '', '', 'Strata 2 (S2)', '', ''],
            ['7', '', '', '', '', '', '', '', '', '', '', 'Strata 3 (S3)', '', ''],
        ];

        foreach ($refData as $rIdx => $rVals) {
            $rowNum = 4 + $rIdx;
            foreach ($rVals as $cIdx => $val) {
                if ($val) {
                    $colLetter = Coordinate::stringFromColumnIndex($cIdx + 1);
                    $sheet2->setCellValue("{$colLetter}{$rowNum}", $val);
                }
            }
        }

        // Return Sheet 1 as active
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Template_Data_Pegawai_SIMPEG.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:10240',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $ext = strtolower($file->getClientOriginalExtension());
        $rows = [];

        if (in_array($ext, ['xlsx', 'xls']) && class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
            try {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
            } catch (\Throwable $e) {
                return back()->with('error', 'Gagal membaca file Excel: ' . $e->getMessage());
            }
        } else {
            // Read CSV
            $handle = fopen($path, 'r');
            if ($handle !== false) {
                $firstLine = fgets($handle);
                rewind($handle);
                $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

                while (($data = fgetcsv($handle, 2000, $delimiter)) !== false) {
                    if (!empty($data[0])) {
                        $data[0] = preg_replace('/[\x00-\x1F\x7F\xEF\xBB\xBF]/', '', $data[0]);
                    }
                    $rows[] = $data;
                }
                fclose($handle);
            }
        }

        if (count($rows) <= 1) {
            return back()->with('error', 'File import kosong.');
        }

        $user = Auth::user();
        $processedCount = 0;
        $errors = [];

        // Dynamic Header Row Finder (look for row containing 'NIP' or 'NAMA PEGAWAI' or 'NPSN')
        $headerRowIndex = 0;
        foreach ($rows as $idx => $r) {
            $rowText = strtoupper(implode(' ', array_filter(array_map(fn($v) => (string)$v, $r))));
            if (str_contains($rowText, 'NIP') || str_contains($rowText, 'NAMA PEGAWAI') || str_contains($rowText, 'STATUS KEPEGAWAIAN')) {
                $headerRowIndex = $idx;
                break;
            }
        }

        $headerRow = array_map(function($h) {
            return strtoupper(trim(preg_replace('/[\x00-\x1F\x7F\xEF\xBB\xBF]/', '', (string)$h)));
        }, $rows[$headerRowIndex]);

        // Build Column Mapping
        $colMap = [];
        foreach ($headerRow as $idx => $name) {
            if (str_contains($name, 'NAMA PEGAWAI') || str_contains($name, 'NAMA_LENGKAP') || $name === 'NAMA') {
                $colMap['nama_lengkap'] = $idx;
            } elseif (str_contains($name, 'NIP') || str_contains($name, 'NIP_NIK')) {
                $colMap['nip'] = $idx;
            } elseif (str_contains($name, 'PANGKAT') || str_contains($name, 'GOL')) {
                $colMap['pangkat_golongan'] = $idx;
            } elseif (str_contains($name, 'NO. SK JABFUNG') || str_contains($name, 'SK_JABFUNG')) {
                $colMap['no_sk_jabfung'] = $idx;
            } elseif (str_contains($name, 'TMT JABFUNG') || str_contains($name, 'TMT_JABFUNG')) {
                $colMap['tmt_jabfung'] = $idx;
            } elseif (str_contains($name, 'NOMOR SERDIK') || str_contains($name, 'NO_SERDIK')) {
                $colMap['no_serdik'] = $idx;
            } elseif (str_contains($name, 'TANGGAL SERDIK') || str_contains($name, 'TGL_SERDIK')) {
                $colMap['tgl_serdik'] = $idx;
            } elseif (str_contains($name, 'JABATAN FUNGSIONAL') || str_contains($name, 'JABATAN_FUNGSIONAL')) {
                $colMap['jabatan_fungsional'] = $idx;
            } elseif (str_contains($name, 'SERDIK')) {
                $colMap['is_serdik'] = $idx;
            } elseif (str_contains($name, 'JENIS PTK') || str_contains($name, 'JENIS_PTK')) {
                $colMap['jenis_ptk'] = $idx;
            } elseif (str_contains($name, 'JENIS GURU') || str_contains($name, 'JENIS_GURU')) {
                $colMap['jenis_guru'] = $idx;
            } elseif (str_contains($name, 'JUMLAH JP') || str_contains($name, 'JP')) {
                $colMap['jumlah_jp'] = $idx;
            } elseif (str_contains($name, 'NUPTK')) {
                $colMap['nuptk'] = $idx;
            } elseif (str_contains($name, 'TINGKAT PENDIDIKAN') || str_contains($name, 'PENDIDIKAN_TERAKHIR') || str_contains($name, 'TINGKAT_PENDIDIKAN')) {
                $colMap['tingkat_pendidikan'] = $idx;
            } elseif (str_contains($name, 'JURUSAN') || str_contains($name, 'PRODI')) {
                $colMap['jurusan_prodi'] = $idx;
            } elseif (str_contains($name, 'NIK')) {
                $colMap['nik'] = $idx;
            } elseif (str_contains($name, 'TEMPAT LAHIR') || str_contains($name, 'TEMPAT_LAHIR')) {
                $colMap['tempat_lahir'] = $idx;
            } elseif (str_contains($name, 'TANGGAL LAHIR') || str_contains($name, 'TANGGAL_LAHIR')) {
                $colMap['tanggal_lahir'] = $idx;
            } elseif (str_contains($name, 'JENIS KELAMIN') || str_contains($name, 'KELAMIN')) {
                $colMap['jenis_kelamin'] = $idx;
            } elseif (str_contains($name, 'AGAMA')) {
                $colMap['agama'] = $idx;
            } elseif (str_contains($name, 'NPSN')) {
                $colMap['npsn'] = $idx;
            }
        }

        // Fallbacks for standard official 25-column template positions
        if (!isset($colMap['nama_lengkap'])) $colMap['nama_lengkap'] = 1; // Col B
        if (!isset($colMap['nip'])) $colMap['nip'] = 2; // Col C
        if (!isset($colMap['status_kepegawaian'])) $colMap['status_kepegawaian'] = 3; // Col D
        if (!isset($colMap['pangkat_golongan'])) $colMap['pangkat_golongan'] = 4; // Col E
        if (!isset($colMap['jabatan_fungsional'])) $colMap['jabatan_fungsional'] = 5; // Col F
        if (!isset($colMap['no_sk_jabfung'])) $colMap['no_sk_jabfung'] = 6; // Col G
        if (!isset($colMap['tmt_jabfung'])) $colMap['tmt_jabfung'] = 7; // Col H
        if (!isset($colMap['is_serdik'])) $colMap['is_serdik'] = 8; // Col I
        if (!isset($colMap['no_serdik'])) $colMap['no_serdik'] = 9; // Col J
        if (!isset($colMap['tgl_serdik'])) $colMap['tgl_serdik'] = 10; // Col K
        if (!isset($colMap['jenis_ptk'])) $colMap['jenis_ptk'] = 11; // Col L
        if (!isset($colMap['jenis_guru'])) $colMap['jenis_guru'] = 12; // Col M
        if (!isset($colMap['jumlah_jp'])) $colMap['jumlah_jp'] = 13; // Col N
        if (!isset($colMap['nuptk'])) $colMap['nuptk'] = 14; // Col O
        if (!isset($colMap['tingkat_pendidikan'])) $colMap['tingkat_pendidikan'] = 15; // Col P
        if (!isset($colMap['jurusan_prodi'])) $colMap['jurusan_prodi'] = 16; // Col Q
        if (!isset($colMap['nik'])) $colMap['nik'] = 17; // Col R
        if (!isset($colMap['tempat_lahir'])) $colMap['tempat_lahir'] = 18; // Col S
        if (!isset($colMap['tanggal_lahir'])) $colMap['tanggal_lahir'] = 19; // Col T
        if (!isset($colMap['jenis_kelamin'])) $colMap['jenis_kelamin'] = 20; // Col U
        if (!isset($colMap['agama'])) $colMap['agama'] = 21; // Col V
        if (!isset($colMap['npsn'])) $colMap['npsn'] = 23; // Col X

        $defaultSekolahId = ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) ? $user->sekolah_id : Sekolah::first()?->id;

        // Process Data Rows (Start after header row / column number row)
        $startDataRow = $headerRowIndex + 1;

        for ($i = $startDataRow; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (empty(array_filter($row))) continue;

            $namaLengkap = trim((string)($row[$colMap['nama_lengkap']] ?? ''));
            $nip = trim((string)($row[$colMap['nip']] ?? ''));
            $nik = trim((string)($row[$colMap['nik']] ?? ''));

            // Clean NIP / NIK (if provided)
            $nipNik = !empty($nip) && $nip !== '-' ? preg_replace('/[^0-9]/', '', $nip) : (!empty($nik) && $nik !== '-' ? preg_replace('/[^0-9]/', '', $nik) : null);

            // Skip header, row numbering, or sub-header rows
            if (empty($namaLengkap) || is_numeric($namaLengkap) || str_contains(strtoupper($namaLengkap), 'NAMA PEGAWAI')) {
                continue;
            }

            // NPSN school lookup
            $npsn = trim((string)($row[$colMap['npsn']] ?? ''));
            $sekolahId = $defaultSekolahId;
            if (!empty($npsn)) {
                $sekolah = Sekolah::where('npsn', $npsn)->first();
                if ($sekolah) {
                    $sekolahId = $sekolah->id;
                }
            }

            if (!$sekolahId) {
                $errors[] = "Baris " . ($i + 1) . ": Sekolah NPSN {$npsn} tidak ditemukan.";
                continue;
            }

            // Map Status Kepegawaian
            $rawStatus = strtoupper(trim((string)($row[$colMap['status_kepegawaian']] ?? '')));
            $statusKepegawaian = 'PNS';
            if (str_contains($rawStatus, 'PARUH WAKTU') || str_contains($rawStatus, 'PW')) {
                $statusKepegawaian = 'PPPK PW';
            } elseif (str_contains($rawStatus, 'PPPK')) {
                $statusKepegawaian = 'PPPK';
            } elseif (str_contains($rawStatus, 'NON') || str_contains($rawStatus, 'HONORER')) {
                $statusKepegawaian = 'Non-ASN';
            }

            // Map Serdik
            $rawSerdik = strtoupper(trim((string)($row[$colMap['is_serdik']] ?? '')));
            $isSerdik = (str_contains($rawSerdik, 'SERDIK') && !str_contains($rawSerdik, 'NON') && !str_contains($rawSerdik, 'BELUM')) || in_array($rawSerdik, ['1', 'YA', 'TRUE', 'SUDAH']);

            // Map Jenis PTK
            $rawPtk = trim((string)($row[$colMap['jenis_ptk']] ?? ''));
            $jenisPtk = 'Pendidik';
            if (str_contains(strtolower($rawPtk), 'tenaga') || str_contains(strtolower($rawPtk), 'tu') || str_contains(strtolower($rawPtk), 'laboran') || str_contains(strtolower($rawPtk), 'pustakawan')) {
                $jenisPtk = 'Tenaga Kependidikan';
            }

            // Map Jenis Guru
            $jenisGuru = trim((string)($row[$colMap['jenis_guru']] ?? ''));
            if (empty($jenisGuru) || $jenisGuru === '-') {
                $jenisGuru = ($jenisPtk === 'Pendidik') ? 'Guru Kelas' : 'Tidak Mengajar';
            }

            // Map Jenis Kelamin
            $rawJk = strtoupper(trim((string)($row[$colMap['jenis_kelamin']] ?? '')));
            $jenisKelamin = null;
            if (str_contains($rawJk, 'PEREMPUAN') || $rawJk === 'P') {
                $jenisKelamin = 'Perempuan';
            } elseif (str_contains($rawJk, 'LAKI') || $rawJk === 'L') {
                $jenisKelamin = 'Laki-Laki';
            }

            // Map Tingkat Pendidikan
            $rawEdu = strtoupper(trim((string)($row[$colMap['tingkat_pendidikan']] ?? '')));
            $tingkatPendidikan = 'S1/D4';
            if (str_contains($rawEdu, 'S3') || str_contains($rawEdu, 'STRATA 3')) {
                $tingkatPendidikan = 'S3';
            } elseif (str_contains($rawEdu, 'S2') || str_contains($rawEdu, 'STRATA 2')) {
                $tingkatPendidikan = 'S2';
            } elseif (str_contains($rawEdu, 'S1') || str_contains($rawEdu, 'D4') || str_contains($rawEdu, 'STRATA 1')) {
                $tingkatPendidikan = 'S1/D4';
            } elseif (str_contains($rawEdu, 'D3') || str_contains($rawEdu, 'DIPLOMA 3')) {
                $tingkatPendidikan = 'D3';
            } elseif (str_contains($rawEdu, 'SMA') || str_contains($rawEdu, 'SMK') || str_contains($rawEdu, 'SEDERAJAT')) {
                $tingkatPendidikan = 'SMA/K';
            }

            // Map Tanggal Lahir
            $rawDob = trim((string)($row[$colMap['tanggal_lahir']] ?? ''));
            $tglLahir = '1990-01-01';
            if (!empty($rawDob) && $rawDob !== '-') {
                try {
                    if (str_contains($rawDob, '/')) {
                        $parts = explode('/', $rawDob);
                        if (count($parts) === 3) {
                            if (strlen($parts[2]) === 4) { // DD/MM/YYYY
                                $tglLahir = sprintf('%04d-%02d-%02d', $parts[2], $parts[1], $parts[0]);
                            } elseif (strlen($parts[0]) === 4) { // YYYY/MM/DD
                                $tglLahir = sprintf('%04d-%02d-%02d', $parts[0], $parts[1], $parts[2]);
                            }
                        }
                    } else {
                        $tglLahir = Carbon::parse($rawDob)->format('Y-m-d');
                    }
                } catch (\Throwable $e) {
                    $tglLahir = '1990-01-01';
                }
            }

            // Jabatan Fungsional
            $jabatan = trim((string)($row[$colMap['jabatan_fungsional']] ?? ''));
            if ($jabatan === '-') $jabatan = null;

            $matchAttr = !empty($nipNik)
                ? ['nip_nik' => $nipNik, 'sekolah_id' => $sekolahId]
                : ['nama_lengkap' => $namaLengkap, 'sekolah_id' => $sekolahId];

            $wasRecentlyCreated = false;
            $existingPegawai = Pegawai::where($matchAttr)->first();
            if (!$existingPegawai) {
                $wasRecentlyCreated = true;
            }

            $pegawaiRecord = Pegawai::updateOrCreate(
                $matchAttr,
                [
                    'sekolah_id' => $sekolahId,
                    'nip_nik' => $nipNik ?: null,
                    'nik' => (!empty($nik) && $nik !== '-') ? preg_replace('/[^0-9]/', '', $nik) : null,
                    'nama_lengkap' => $namaLengkap,
                    'status_kepegawaian' => $statusKepegawaian,
                    'pangkat_golongan' => trim((string)($row[$colMap['pangkat_golongan']] ?? '')) ?: null,
                    'jabatan_fungsional' => $jabatan,
                    'no_sk_jabfung' => trim((string)($row[$colMap['no_sk_jabfung']] ?? '')) ?: null,
                    'tmt_jabfung' => trim((string)($row[$colMap['tmt_jabfung']] ?? '')) ?: null,
                    'is_serdik' => $isSerdik,
                    'no_serdik' => trim((string)($row[$colMap['no_serdik']] ?? '')) ?: null,
                    'tgl_serdik' => trim((string)($row[$colMap['tgl_serdik']] ?? '')) ?: null,
                    'jenis_ptk' => $jenisPtk,
                    'jenis_guru' => $jenisGuru,
                    'jumlah_jp' => trim((string)($row[$colMap['jumlah_jp']] ?? '')) ?: null,
                    'nuptk' => trim((string)($row[$colMap['nuptk']] ?? '')) ?: null,
                    'tingkat_pendidikan' => $tingkatPendidikan,
                    'jurusan_prodi' => trim((string)($row[$colMap['jurusan_prodi']] ?? '')) ?: null,
                    'tempat_lahir' => trim((string)($row[$colMap['tempat_lahir']] ?? '')) ?: null,
                    'tanggal_lahir' => $tglLahir,
                    'jenis_kelamin' => $jenisKelamin,
                    'agama' => trim((string)($row[$colMap['agama']] ?? '')) ?: null,
                ]
            );

            // Log created via import with all fields
            if ($wasRecentlyCreated) {
                $allFields = [];
                foreach (['nama_lengkap','nip_nik','nik','status_kepegawaian','pangkat_golongan','jabatan_fungsional','no_sk_jabfung','tmt_jabfung','is_serdik','no_serdik','tgl_serdik','jenis_ptk','jenis_guru','jumlah_jp','nuptk','tingkat_pendidikan','jurusan_prodi','tempat_lahir','tanggal_lahir','jenis_kelamin','agama','sekolah_id'] as $f) {
                    $val = $pegawaiRecord->$f;
                    if (!is_null($val) && $val !== '') {
                        $allFields[$f] = ['data' => ($val === true ? 'Ya' : ($val === false ? 'Tidak' : (string)$val))];
                    }
                }
                ActivityLog::record($pegawaiRecord, 'imported', $allFields, 'Data Pegawai Pertama Kali Dimasukkan via Import Excel');
            }

            $importedPegawaiIds[] = $pegawaiRecord->id;
            $processedCount++;
        }

        // Auto-clean: Delete old/misplaced pegawais for schools touched during this import
        if (!empty($importedPegawaiIds)) {
            $sekolahIds = array_unique(array_filter(array_map(fn($id) => Pegawai::find($id)?->sekolah_id, $importedPegawaiIds)));
            foreach ($sekolahIds as $sId) {
                Pegawai::where('sekolah_id', $sId)
                    ->whereNotIn('id', $importedPegawaiIds)
                    ->delete();
            }
        }

        if (class_exists(ExcelImport::class)) {
            try {
                ExcelImport::create([
                    'filename' => $file->getClientOriginalName(),
                    'original_name' => $file->getClientOriginalName(),
                    'imported_by' => Auth::id() ?? 1,
                    'rows_processed' => $processedCount,
                    'status' => 'success',
                    'notes' => 'Import sukses ' . $processedCount . ' data pegawai dari template resmi.',
                ]);
            } catch (\Throwable $e) {
                // Ignore
            }
        }

        $msg = "Berhasil mengimpor {$processedCount} data pegawai dari template resmi Dinas Pendidikan.";
        if (count($errors) > 0) {
            $msg .= " Catatan: " . implode(', ', array_slice($errors, 0, 3));
        }

        return redirect()->route('pegawai.index')->with('success', $msg);
    }
}
