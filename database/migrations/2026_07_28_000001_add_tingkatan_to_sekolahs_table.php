<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('sekolahs', 'tingkatan')) {
            Schema::table('sekolahs', function (Blueprint $table) {
                $table->string('tingkatan', 10)->nullable()->after('nama_sekolah')->index();
            });
        }

        // Auto-populate tingkatan based on existing nama_sekolah
        DB::statement("UPDATE sekolahs SET tingkatan = 'TK' WHERE UPPER(nama_sekolah) LIKE 'TK%'");
        DB::statement("UPDATE sekolahs SET tingkatan = 'SD' WHERE UPPER(nama_sekolah) LIKE 'SD%' AND tingkatan IS NULL");
        DB::statement("UPDATE sekolahs SET tingkatan = 'SMP' WHERE UPPER(nama_sekolah) LIKE 'SMP%' AND tingkatan IS NULL");
        DB::statement("UPDATE sekolahs SET tingkatan = 'SMA' WHERE UPPER(nama_sekolah) LIKE 'SMA%' AND tingkatan IS NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sekolahs', function (Blueprint $table) {
            $table->dropColumn('tingkatan');
        });
    }
};
