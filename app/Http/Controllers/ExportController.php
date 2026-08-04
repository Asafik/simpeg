<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function exportExcel(Request $request)
    {
        $user = Auth::user();
        $filters = $request->all();

        $query = Pegawai::with('sekolahs')->latest();

        if ($user->isOperatorSekolah()) {
            $filters['sekolah_id'] = $user->sekolah_id ?? -1;
        }

        $query->filterKriteria($filters);
        $pegawais = $query->get();

        $filename = 'rekap_pegawai_simpeg_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($pegawais) {
            $file = fopen('php://output', 'w');
            // UTF-8 BOM for Excel compatibility
            fputs($file, "\xEF\xBB\xBF");

            // CSV Header Row
            fputcsv($file, [
                'No',
                'NPSN',
                'Nama Satuan Pendidikan',
                'Kecamatan',
                'NIP/NIK Pegawai',
                'Nama Lengkap Pegawai',
                'Status Kepegawaian',
                'Jabatan Fungsional',
                'Sertifikasi Pendidik (Serdik)',
                'Jenis PTK',
                'Jenis Guru',
                'Tingkat Pendidikan',
                'Tanggal Lahir',
                'Usia (Tahun)',
            ]);

            foreach ($pegawais as $index => $p) {
                fputcsv($file, [
                    $index + 1,
                    $p->sekolah ? $p->sekolah->npsn : '-',
                    $p->sekolah ? $p->sekolah->nama_sekolah : '-',
                    $p->sekolah ? $p->sekolah->kecamatan : '-',
                    $p->nip_nik,
                    $p->nama_lengkap,
                    $p->status_kepegawaian,
                    $p->jabatan_fungsional ?: '-',
                    $p->is_serdik ? 'Sudah Serdik' : 'Belum Serdik',
                    $p->jenis_ptk,
                    $p->jenis_guru ?: '-',
                    $p->tingkat_pendidikan,
                    $p->tanggal_lahir ? $p->tanggal_lahir->format('d-m-Y') : '-',
                    $p->usia,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $filters = $request->all();

        $query = Pegawai::with('sekolahs')->latest();

        if ($user->isOperatorSekolah()) {
            $filters['sekolah_id'] = $user->sekolah_id ?? -1;
        }

        $query->filterKriteria($filters);
        $pegawais = $query->get();

        return view('reports.pdf_print', compact('pegawais', 'filters'));
    }
}
