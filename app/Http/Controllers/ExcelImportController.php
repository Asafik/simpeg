<?php

namespace App\Http\Controllers;

use App\Models\ExcelImport;
use App\Models\Pegawai;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExcelImportController extends Controller
{
    public function showImportForm()
    {
        $imports = ExcelImport::with('user')->latest()->paginate(10);
        return view('excel.import', compact('imports'));
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:csv,txt,xlsx,xls|max:5048',
        ]);

        $file = $request->file('excel_file');
        $originalName = $file->getClientOriginalName();
        $filePath = $file->store('imports', 'public');

        $fullPath = storage_path('app/public/' . $filePath);

        $processedRows = 0;

        try {
            DB::beginTransaction();

            $handle = fopen($fullPath, 'r');
            if ($handle !== false) {
                $header = fgetcsv($handle, 4096, ',');
                
                // If delimiter might be semicolon
                if ($header && count($header) === 1 && str_contains($header[0], ';')) {
                    rewind($handle);
                    $header = fgetcsv($handle, 4096, ';');
                    $delimiter = ';';
                } else {
                    $delimiter = ',';
                }

                // Clean headers (replace spaces with underscores)
                $cleanHeader = array_map(function ($col) {
                    $cleaned = strtolower(trim(preg_replace('/[^a-zA-Z0-9_ ]/', '', $col)));
                    return str_replace(' ', '_', $cleaned);
                }, $header ?? []);

                while (($row = fgetcsv($handle, 4096, $delimiter)) !== false) {
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    $rowData = [];
                    foreach ($cleanHeader as $idx => $headerName) {
                        $rowData[$headerName] = isset($row[$idx]) ? trim($row[$idx]) : null;
                    }

                    // Extract School metadata from standard Google Form / Excel upload
                    // Header keys mapping
                    $npsn = $this->extractValue($rowData, ['npsn', 'npsn_sekolah', 'nomor_pokok_sekolah_nasional']);
                    $namaSekolah = $this->extractValue($rowData, ['nama_satuan_pendidikan', 'nama_sekolah', 'satuan_pendidikan']);
                    $kecamatan = $this->extractValue($rowData, ['kecamatan_satuan_pendidikan', 'kecamatan']);
                    $namaKepsek = $this->extractValue($rowData, ['nama_kepala_sekolah', 'nama_kepsek']);
                    $nipKepsek = $this->extractValue($rowData, ['nip_kepala_sekolah', 'nip_kepsek']);
                    $statusKepsek = $this->extractValue($rowData, ['status_kepala_sekolah', 'status_kepsek']);
                    $emailSekolah = $this->extractValue($rowData, ['email_address', 'email', 'email_sekolah']);

                    if ($npsn && $namaSekolah) {
                        $sekolah = Sekolah::updateOrCreate(
                            ['npsn' => $npsn],
                            [
                                'nama_sekolah' => $namaSekolah,
                                'kecamatan' => $kecamatan ?: 'Kecamatan Utama',
                                'nama_kepala_sekolah' => $namaKepsek,
                                'nip_kepala_sekolah' => $nipKepsek,
                                'status_kepala_sekolah' => $statusKepsek ?: 'Definitif',
                                'email_sekolah' => $emailSekolah,
                            ]
                        );

                        // If line also contains Pegawai details
                        $nipNik = $this->extractValue($rowData, ['nip_nik', 'nip', 'nik', 'nipnik']);
                        $namaPegawai = $this->extractValue($rowData, ['nama_pegawai', 'nama_lengkap', 'nama']);

                        if ($nipNik && $namaPegawai) {
                            $statusKepegawaian = $this->normalizeStatusKepegawaian($this->extractValue($rowData, ['status_kepegawaian', 'status_pegawai', 'status']));
                            $jabatan = $this->extractValue($rowData, ['jabatan_fungsional', 'jabatan', 'jabatan_ptk']);
                            $isSerdikRaw = $this->extractValue($rowData, ['sertifikasi_pendicik', 'serdik', 'is_serdik', 'apakah_sudah_serdik']);
                            $isSerdik = in_array(strtolower((string)$isSerdikRaw), ['ya', '1', 'true', 'serdik', 'sudah']);
                            $jenisPtk = $this->normalizeJenisPtk($this->extractValue($rowData, ['jenis_ptk', 'ptk']));
                            $jenisGuru = $this->extractValue($rowData, ['jenis_guru', 'guru_mapel', 'mapel']);
                            $pendidikan = $this->normalizePendidikan($this->extractValue($rowData, ['tingkat_pendidikan', 'pendidikan', 'pendidikan_terakhir']));
                            $tglLahir = $this->normalizeTanggalLahir($this->extractValue($rowData, ['tanggal_lahir', 'tgl_lahir', 'tgl']));

                            $pegawaiRecord = Pegawai::updateOrCreate(
                                ['nip_nik' => $nipNik],
                                [
                                    'nama_lengkap' => $namaPegawai,
                                    'status_kepegawaian' => $statusKepegawaian,
                                    'jabatan_fungsional' => $jabatan ?: 'Guru Ahli Pertama',
                                    'is_serdik' => $isSerdik,
                                    'jenis_ptk' => $jenisPtk,
                                    'jenis_guru' => $jenisGuru ?: 'Guru Kelas',
                                    'tingkat_pendidikan' => $pendidikan,
                                    'tanggal_lahir' => $tglLahir,
                                ]
                            );

                            // Attach sekolah via pivot if not already attached
                            if (!$pegawaiRecord->sekolahs()->where('sekolahs.id', $sekolah->id)->exists()) {
                                $isPrimary = $pegawaiRecord->sekolahs()->count() === 0;
                                $pegawaiRecord->sekolahs()->attach($sekolah->id, ['is_primary' => $isPrimary]);
                            }
                        }

                        $processedRows++;
                    }
                }
                fclose($handle);
            }

            DB::commit();

            ExcelImport::create([
                'filename' => $filePath,
                'original_name' => $originalName,
                'imported_by' => Auth::id(),
                'rows_processed' => $processedRows,
                'status' => 'success',
                'notes' => "Berhasil memproses {$processedRows} data dari file Excel/CSV.",
            ]);

            return redirect()->route('excel.import.form')
                ->with('success', "Import Excel Berhasil! {$processedRows} data sekolah/pegawai telah diproses.");

        } catch (\Throwable $e) {
            DB::rollBack();

            ExcelImport::create([
                'filename' => $filePath,
                'original_name' => $originalName,
                'imported_by' => Auth::id(),
                'rows_processed' => 0,
                'status' => 'failed',
                'notes' => 'Gagal import: ' . $e->getMessage(),
            ]);

            return back()->withErrors(['excel_file' => 'Gagal memproses file Excel: ' . $e->getMessage()]);
        }
    }

    private function extractValue(array $rowData, array $possibleKeys)
    {
        foreach ($possibleKeys as $key) {
            if (isset($rowData[$key]) && $rowData[$key] !== '') {
                return $rowData[$key];
            }
        }
        return null;
    }

    private function normalizeStatusKepegawaian($val): string
    {
        $val = strtoupper((string)$val);
        if (str_contains($val, 'PARUH WAKTU') || str_contains($val, 'PW')) return 'PPPK PW';
        if (str_contains($val, 'PPPK') || str_contains($val, 'P3K')) return 'PPPK';
        if (str_contains($val, 'PNS') || str_contains($val, 'ASN')) return 'PNS';
        return 'Non-ASN';
    }

    private function normalizeJenisPtk($val): string
    {
        $val = strtolower((string)$val);
        if (str_contains($val, 'tenaga') || str_contains($val, 'tu') || str_contains($val, 'kependidikan')) {
            return 'Tenaga Kependidikan';
        }
        return 'Pendidik';
    }

    private function normalizePendidikan($val): string
    {
        $val = strtoupper((string)$val);
        if (str_contains($val, 'S3')) return 'S3';
        if (str_contains($val, 'S2')) return 'S2';
        if (str_contains($val, 'D3')) return 'D3';
        if (str_contains($val, 'SMA') || str_contains($val, 'SMK') || str_contains($val, 'MA')) return 'SMA/K';
        return 'S1/D4';
    }

    private function normalizeTanggalLahir($val): string
    {
        if (empty($val)) {
            return '1990-01-01';
        }
        $time = strtotime($val);
        return $time ? date('Y-m-d', $time) : '1990-01-01';
    }
}
