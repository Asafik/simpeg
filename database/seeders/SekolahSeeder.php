<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SekolahSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = 'C:/Users/ilham/Downloads/Data Pegawai Satuan Pendidikan Tahun 2026 (Jawaban) (1).xlsx';

        if (file_exists($filePath)) {
            try {
                $spreadsheet = IOFactory::load($filePath);
                $sheet = $spreadsheet->getActiveSheet();
                $rows = $sheet->toArray();

                for ($i = 1; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    $npsn = trim((string) ($row[4] ?? ''));

                    if (empty($npsn) || !is_numeric($npsn)) {
                        continue;
                    }

                    $namaKepala = trim((string) ($row[1] ?? ''));
                    $nipKepala = trim((string) ($row[2] ?? ''));
                    $namaSekolah = trim((string) ($row[3] ?? ''));
                    $kecamatan = trim((string) ($row[5] ?? ''));
                    $statusKepala = trim((string) ($row[8] ?? 'Definitif'));
                    $emailSekolah = trim((string) ($row[9] ?? ''));

                    Sekolah::updateOrCreate(
                        ['npsn' => $npsn],
                        [
                            'nama_sekolah' => $namaSekolah ?: 'Sekolah NPSN ' . $npsn,
                            'kecamatan' => $kecamatan ?: 'Kecamatan Utama',
                            'nama_kepala_sekolah' => $namaKepala ?: null,
                            'nip_kepala_sekolah' => $nipKepala ?: null,
                            'status_kepala_sekolah' => $statusKepala ?: 'Definitif',
                            'email_sekolah' => $emailSekolah ?: null,
                        ]
                    );
                }
            } catch (\Throwable $e) {
                // Ignore if not present
            }
        }
    }
}


