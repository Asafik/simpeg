<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    public function run(): void
    {
        $sekolahs = [
            [
                'npsn' => '10201001',
                'nama_sekolah' => 'SD Negeri 01 Kota',
                'kecamatan' => 'Medan Kota',
                'nama_kepala_sekolah' => 'H. Ahmad Dahlan, S.Pd., M.M.',
                'nip_kepala_sekolah' => '197508121998031002',
                'status_kepala_sekolah' => 'Definitif',
                'email_sekolah' => 'sdn01kota@dinas.sch.id',
                'alamat' => 'Jl. Sudirman No. 12, Medan Kota',
            ],
            [
                'npsn' => '10201002',
                'nama_sekolah' => 'SD Negeri 05 Barat',
                'kecamatan' => 'Medan Barat',
                'nama_kepala_sekolah' => 'Dra. Hj. Nurhayati, M.Pd.',
                'nip_kepala_sekolah' => '196805151992032001',
                'status_kepala_sekolah' => 'Definitif',
                'email_sekolah' => 'sdn05barat@dinas.sch.id',
                'alamat' => 'Jl. Gatot Subroto No. 45, Medan Barat',
            ],
            [
                'npsn' => '10201003',
                'nama_sekolah' => 'SMP Negeri 1 Medan',
                'kecamatan' => 'Medan Timur',
                'nama_kepala_sekolah' => 'Dr. Bambang Sutrisno, M.Si.',
                'nip_kepala_sekolah' => '197103201997021004',
                'status_kepala_sekolah' => 'Plt',
                'email_sekolah' => 'smpn1medan@dinas.sch.id',
                'alamat' => 'Jl. Veteran No. 88, Medan Timur',
            ],
            [
                'npsn' => '10201004',
                'nama_sekolah' => 'SMP Negeri 4 Helvetia',
                'kecamatan' => 'Medan Helvetia',
                'nama_kepala_sekolah' => 'Siti Zubaidah, S.Pd.',
                'nip_kepala_sekolah' => '198211042006042015',
                'status_kepala_sekolah' => 'Definitif',
                'email_sekolah' => 'smpn4helvetia@dinas.sch.id',
                'alamat' => 'Jl. Kapten Muslim No. 102, Medan Helvetia',
            ],
            [
                'npsn' => '10201005',
                'nama_sekolah' => 'SD Negeri 10 Amplas',
                'kecamatan' => 'Medan Amplas',
                'nama_kepala_sekolah' => 'Rahmat Hidayat, S.Pd.',
                'nip_kepala_sekolah' => '197904012003121003',
                'status_kepala_sekolah' => 'Plh',
                'email_sekolah' => 'sdn10amplas@dinas.sch.id',
                'alamat' => 'Jl. Sisingamangaraja No. 210, Medan Amplas',
            ],
        ];

        foreach ($sekolahs as $data) {
            Sekolah::updateOrCreate(['npsn' => $data['npsn']], $data);
        }
    }
}
