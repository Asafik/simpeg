<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use App\Models\Sekolah;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $sekolahs = Sekolah::all();

        if ($sekolahs->isEmpty()) {
            return;
        }

        $samplePegawai = [
            [
                'sekolah_npsn' => '10201001',
                'nip_nik' => '198506122010011005',
                'nama_lengkap' => 'Budi Santoso, S.Pd.',
                'status_kepegawaian' => 'PNS',
                'jabatan_fungsional' => 'Guru Ahli Muda',
                'is_serdik' => true,
                'jenis_ptk' => 'Pendidik',
                'jenis_guru' => 'Guru Kelas',
                'tingkat_pendidikan' => 'S1/D4',
                'tanggal_lahir' => '1985-06-12',
            ],
            [
                'sekolah_npsn' => '10201001',
                'nip_nik' => '199203152023212011',
                'nama_lengkap' => 'Dewi Lestari, S.Pd.',
                'status_kepegawaian' => 'PPPK',
                'jabatan_fungsional' => 'Guru Ahli Pertama',
                'is_serdik' => true,
                'jenis_ptk' => 'Pendidik',
                'jenis_guru' => 'Guru Mata Pelajaran',
                'tingkat_pendidikan' => 'S1/D4',
                'tanggal_lahir' => '1992-03-15',
            ],
            [
                'sekolah_npsn' => '10201001',
                'nip_nik' => '3271018804950002',
                'nama_lengkap' => 'Eko Prasetyo, A.Md.',
                'status_kepegawaian' => 'PPPK PW',
                'jabatan_fungsional' => 'Tenaga Administrasi Sekolah',
                'is_serdik' => false,
                'jenis_ptk' => 'Tenaga Kependidikan',
                'jenis_guru' => null,
                'tingkat_pendidikan' => 'D3',
                'tanggal_lahir' => '1995-04-18',
            ],
            [
                'sekolah_npsn' => '10201002',
                'nip_nik' => '197302101999032002',
                'nama_lengkap' => 'Sri Wahyuni, M.Pd.',
                'status_kepegawaian' => 'PNS',
                'jabatan_fungsional' => 'Guru Ahli Madya',
                'is_serdik' => true,
                'jenis_ptk' => 'Pendidik',
                'jenis_guru' => 'Guru Kelas',
                'tingkat_pendidikan' => 'S2',
                'tanggal_lahir' => '1973-02-10',
            ],
            [
                'sekolah_npsn' => '10201002',
                'nip_nik' => '1271056708980004',
                'nama_lengkap' => 'Rina Kurniawati, S.Pd.',
                'status_kepegawaian' => 'Non-ASN',
                'jabatan_fungsional' => 'Guru Honorer',
                'is_serdik' => false,
                'jenis_ptk' => 'Pendidik',
                'jenis_guru' => 'Guru BK',
                'tingkat_pendidikan' => 'S1/D4',
                'tanggal_lahir' => '1998-08-27',
            ],
            [
                'sekolah_npsn' => '10201003',
                'nip_nik' => '197103201997021004',
                'nama_lengkap' => 'Dr. Bambang Sutrisno, M.Si.',
                'status_kepegawaian' => 'PNS',
                'jabatan_fungsional' => 'Kepala Sekolah',
                'is_serdik' => true,
                'jenis_ptk' => 'Pendidik',
                'jenis_guru' => 'Guru Mata Pelajaran',
                'tingkat_pendidikan' => 'S3',
                'tanggal_lahir' => '1971-03-20',
            ],
            [
                'sekolah_npsn' => '10201003',
                'nip_nik' => '199011022022031008',
                'nama_lengkap' => 'Fahri Ramadhan, S.Pd.',
                'status_kepegawaian' => 'PPPK',
                'jabatan_fungsional' => 'Guru Ahli Pertama',
                'is_serdik' => false,
                'jenis_ptk' => 'Pendidik',
                'jenis_guru' => 'Guru Inklusi',
                'tingkat_pendidikan' => 'S1/D4',
                'tanggal_lahir' => '1990-11-02',
            ],
            [
                'sekolah_npsn' => '10201004',
                'nip_nik' => '1271021203010009',
                'nama_lengkap' => 'Andi Wijaya, S.T.',
                'status_kepegawaian' => 'Non-ASN',
                'jabatan_fungsional' => 'Operator Dapodik / IT',
                'is_serdik' => false,
                'jenis_ptk' => 'Tenaga Kependidikan',
                'jenis_guru' => null,
                'tingkat_pendidikan' => 'S1/D4',
                'tanggal_lahir' => '2001-03-12',
            ],
            [
                'sekolah_npsn' => '10201005',
                'nip_nik' => '196708051991031003',
                'nama_lengkap' => 'Drs. Hendra Utama',
                'status_kepegawaian' => 'PNS',
                'jabatan_fungsional' => 'Guru Ahli Utama',
                'is_serdik' => true,
                'jenis_ptk' => 'Pendidik',
                'jenis_guru' => 'Guru Mata Pelajaran',
                'tingkat_pendidikan' => 'S1/D4',
                'tanggal_lahir' => '1967-08-05',
            ]
        ];

        foreach ($samplePegawai as $data) {
            $sekolah = $sekolahs->where('npsn', $data['sekolah_npsn'])->first();
            if ($sekolah) {
                Pegawai::updateOrCreate(
                    ['nip_nik' => $data['nip_nik']],
                    [
                        'sekolah_id' => $sekolah->id,
                        'nama_lengkap' => $data['nama_lengkap'],
                        'status_kepegawaian' => $data['status_kepegawaian'],
                        'jabatan_fungsional' => $data['jabatan_fungsional'],
                        'is_serdik' => $data['is_serdik'],
                        'jenis_ptk' => $data['jenis_ptk'],
                        'jenis_guru' => $data['jenis_guru'],
                        'tingkat_pendidikan' => $data['tingkat_pendidikan'],
                        'tanggal_lahir' => $data['tanggal_lahir'],
                    ]
                );
            }
        }
    }
}
