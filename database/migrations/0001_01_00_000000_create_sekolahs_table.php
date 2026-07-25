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
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('npsn', 20)->unique();
            $table->string('nama_sekolah', 150);
            $table->string('kecamatan', 100);
            $table->string('nama_kepala_sekolah', 150)->nullable();
            $table->string('nip_kepala_sekolah', 30)->nullable();
            $table->string('status_kepala_sekolah', 50)->default('Definitif'); // Definitif, Plt, Plh
            $table->string('email_sekolah', 100)->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolahs');
    }
};
