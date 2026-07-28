<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            if (!Schema::hasColumn('pegawais', 'status_verifikasi')) {
                $table->enum('status_verifikasi', ['DRAFT', 'MENUNGGU', 'REVISI', 'DISETUJUI'])->default('DRAFT')->after('file_ijazah');
            }
            if (!Schema::hasColumn('pegawais', 'catatan_verifikasi')) {
                $table->text('catatan_verifikasi')->nullable()->after('status_verifikasi');
            }
            if (!Schema::hasColumn('pegawais', 'tgl_verifikasi')) {
                $table->timestamp('tgl_verifikasi')->nullable()->after('catatan_verifikasi');
            }
            if (!Schema::hasColumn('pegawais', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete()->after('tgl_verifikasi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['status_verifikasi', 'catatan_verifikasi', 'tgl_verifikasi', 'verified_by']);
        });
    }
};
