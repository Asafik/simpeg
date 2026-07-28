<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('loggable_type', 100); // App\Models\Pegawai or App\Models\Sekolah
            $table->unsignedBigInteger('loggable_id');
            $table->string('action', 30); // created, updated, deleted, imported
            $table->string('label', 255)->nullable(); // Display label e.g. "Edit Data Pegawai"
            $table->json('changes')->nullable(); // {"field": {"old": "X", "new": "Y"}, ...}
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name', 150)->nullable(); // Cached user name
            $table->string('user_role', 50)->nullable(); // Admin Dinas, Operator Sekolah
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['loggable_type', 'loggable_id']);
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
