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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->string('kategori', 100)->default('Informasi Umum');
            $table->text('ringkasan')->nullable();
            $table->longText('isi');
            $table->unsignedBigInteger('penulis_id')->nullable();
            $table->string('penulis_nama', 150)->nullable();
            $table->boolean('is_published')->default(true);
            $table->string('lampiran_file', 255)->nullable();
            $table->timestamps();

            $table->index('is_published');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
