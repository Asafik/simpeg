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
        // Admin Dinas
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator Dinas Pendidikan',
                'email' => 'admin@dinas.go.id',
                'password' => Hash::make('password'),
                'role' => 'ADMIN_DINAS',
                'sekolah_id' => null,
            ]
        );

        $sd1 = Sekolah::where('npsn', '10201001')->first();
        if ($sd1) {
            User::updateOrCreate(
                ['username' => 'operator_sd1'],
                [
                    'name' => 'Operator SD Negeri 01 Kota',
                    'email' => 'operator.sdn01@dinas.sch.id',
                    'password' => Hash::make('password'),
                    'role' => 'OPERATOR_SEKOLAH',
                    'sekolah_id' => $sd1->id,
                ]
            );
        }

        $smp1 = Sekolah::where('npsn', '10201003')->first();
        if ($smp1) {
            User::updateOrCreate(
                ['username' => 'operator_smp1'],
                [
                    'name' => 'Operator SMP Negeri 1 Medan',
                    'email' => 'operator.smpn1@dinas.sch.id',
                    'password' => Hash::make('password'),
                    'role' => 'OPERATOR_SEKOLAH',
                    'sekolah_id' => $smp1->id,
                ]
            );
        }
    }
}
