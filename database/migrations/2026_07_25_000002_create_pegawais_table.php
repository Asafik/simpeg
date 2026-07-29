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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->cascadeOnDelete();
            $table->string('nip_nik', 30)->nullable();
            $table->string('nik', 30)->nullable();
            $table->string('nama_lengkap', 150);
            $table->enum('status_kepegawaian', ['PNS', 'PPPK', 'PPPK PW', 'Non-ASN'])->default('Non-ASN');
            $table->string('pangkat_golongan', 50)->nullable();
            $table->string('jabatan_fungsional', 100)->nullable();
            $table->string('no_sk_jabfung', 100)->nullable();
            $table->string('tmt_jabfung', 50)->nullable();
            $table->boolean('is_serdik')->default(false);
            $table->string('no_serdik', 100)->nullable();
            $table->string('tgl_serdik', 50)->nullable();
            $table->enum('jenis_ptk', ['Pendidik', 'Tenaga Kependidikan'])->default('Pendidik');
            $table->string('jenis_guru', 100)->nullable();
            $table->string('jumlah_jp', 30)->nullable();
            $table->string('nuptk', 30)->nullable();
            $table->enum('tingkat_pendidikan', ['SMA/K', 'D3', 'S1/D4', 'S2', 'S3'])->default('S1/D4');
            $table->string('jurusan_prodi', 150)->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable();
            $table->string('agama', 50)->nullable();
            $table->string('file_sk')->nullable();
            $table->string('file_serdik')->nullable();
            $table->string('file_ijazah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};