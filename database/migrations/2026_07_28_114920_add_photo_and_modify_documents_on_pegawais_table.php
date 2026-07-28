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
            $table->string('photo_profile')->nullable()->after('agama');
            $table->text('file_sk')->nullable()->change();
            $table->text('file_serdik')->nullable()->change();
            $table->text('file_ijazah')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropColumn('photo_profile');
            $table->string('file_sk', 255)->nullable()->change();
            $table->string('file_serdik', 255)->nullable()->change();
            $table->string('file_ijazah', 255)->nullable()->change();
        });
    }
};
