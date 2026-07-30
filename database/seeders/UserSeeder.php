<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Dinas Principal Account
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator Dinas Pendidikan',
                'email' => 'admin@mail.com',
                'password' => Hash::make('password'),
                'role' => 'ADMIN_DINAS',
                'sekolah_id' => null,
            ]
        );

        // Dynamically create Operator accounts for every seeded school
        $defaultPassword = Hash::make('password');
        $sekolahs = Sekolah::all();

        foreach ($sekolahs as $sekolah) {
            $username = 'ops_' . $sekolah->npsn;
            User::updateOrCreate(
                ['username' => $username],
                [
                    'name' => 'Operator ' . $sekolah->nama_sekolah,
                    'email' => $username . '@dinas.sch.id',
                    'password' => $defaultPassword,
                    'role' => 'OPERATOR_SEKOLAH',
                    'sekolah_id' => $sekolah->id,
                ]
            );
        }
    }
}

