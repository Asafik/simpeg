<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with 984 master clean schools and user accounts.
     */
    public function run(): void
    {
        $this->call([
            SekolahSeeder::class,
            UserSeeder::class,
        ]);
    }
}
