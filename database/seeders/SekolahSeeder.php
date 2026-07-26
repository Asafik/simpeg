<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SekolahSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('seeders/sekolahs_data.json');

        if (File::exists($jsonPath)) {
            $jsonContent = File::get($jsonPath);
            $sekolahs = json_decode($jsonContent, true);

            foreach ($sekolahs as $data) {
                Sekolah::updateOrCreate(
                    ['npsn' => $data['npsn']],
                    [
                        'nama_sekolah'          => $data['nama_sekolah'],
                        'kecamatan'             => $data['kecamatan'],
                        'nama_kepala_sekolah'   => $data['nama_kepala_sekolah'],
                        'nip_kepala_sekolah'    => $data['nip_kepala_sekolah'],
                        'status_kepala_sekolah' => $data['status_kepala_sekolah'] ?? 'Definitif',
                        'email_sekolah'         => !empty($data['email_sekolah']) ? $data['email_sekolah'] : strtolower(str_replace(' ', '', $data['nama_sekolah'])) . '@dinas.sch.id',
                        'alamat'                => $data['alamat'] ?? ('Jl. Pendidikan, Kec. ' . $data['kecamatan']),
                    ]
                );
            }
        } else {
            // Default Fallback
            Sekolah::updateOrCreate(
                ['npsn' => '20523594'],
                [
                    'nama_sekolah'          => 'SDN Kertonegoro 01',
                    'kecamatan'             => 'Jenggawah',
                    'nama_kepala_sekolah'   => 'NURUL WIDIYASTUTIK, S.Pd',
                    'nip_kepala_sekolah'    => '197205221994032006',
                    'status_kepala_sekolah' => 'Plt',
                    'email_sekolah'         => 'sdnkertonegoro01@dinas.sch.id',
                    'alamat'                => 'Jl. Pendidikan No. 01, Kec. Jenggawah',
                ]
            );
        }
    }
}
