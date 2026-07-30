<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Populate pegawai_sekolah pivot from existing sekolah_id, then drop the column.
     */
    public function up(): void
    {
        // Step 1: Populate pivot table from existing sekolah_id
        $pegawais = DB::table('pegawais')->whereNotNull('sekolah_id')->get(['id', 'sekolah_id']);

        $inserts = [];
        foreach ($pegawais as $p) {
            $inserts[] = [
                'pegawai_id' => $p->id,
                'sekolah_id' => $p->sekolah_id,
                'is_primary' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert in chunks to avoid memory issues with 12k+ records
        foreach (array_chunk($inserts, 500) as $chunk) {
            DB::table('pegawai_sekolah')->insert($chunk);
        }

        // Step 2: Drop foreign key and column sekolah_id from pegawais
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropForeign(['sekolah_id']);
            $table->dropColumn('sekolah_id');
        });
    }

    /**
     * Reverse: Re-add sekolah_id column and repopulate from pivot.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->foreignId('sekolah_id')->nullable()->after('id')->constrained('sekolahs')->cascadeOnDelete();
        });

        // Restore sekolah_id from pivot (use primary entry)
        $pivots = DB::table('pegawai_sekolah')->where('is_primary', true)->get();
        foreach ($pivots as $pivot) {
            DB::table('pegawais')->where('id', $pivot->pegawai_id)->update(['sekolah_id' => $pivot->sekolah_id]);
        }
    }
};
