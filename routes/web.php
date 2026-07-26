<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;

// Public Root URL & Landing Page Routes (Managed by LandingController)
Route::get('/', [LandingController::class, 'index'])->name('landing.home');
Route::get('/landing', [LandingController::class, 'index'])->name('landing');

// Clean Public URLs with Controller Methods
Route::get('/statistik', [LandingController::class, 'statistik'])->name('landing.statistik');
Route::get('/layanan', [LandingController::class, 'layanan'])->name('landing.layanan');
Route::get('/cek-ptk', [LandingController::class, 'cekPtk'])->name('landing.cek-ptk');
Route::get('/pengumuman', [LandingController::class, 'pengumuman'])->name('landing.pengumuman');

// Alias Routes with /landing prefix
Route::get('/landing/statistik', [LandingController::class, 'statistik']);
Route::get('/landing/layanan', [LandingController::class, 'layanan']);
Route::get('/landing/cek-ptk', [LandingController::class, 'cekPtk']);
Route::get('/landing/pengumuman', [LandingController::class, 'pengumuman']);

// Guest / Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout']);

// Protected System Routes (Must Be Logged In)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::get('/pegawai/{pegawai}', [PegawaiController::class, 'show'])->name('pegawai.show');

    Route::get('/sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
    Route::get('/sekolah/create', [SekolahController::class, 'create'])->name('sekolah.create');
    Route::post('/sekolah', [SekolahController::class, 'store'])->name('sekolah.store');
    Route::get('/sekolah/{sekolah}', [SekolahController::class, 'show'])->name('sekolah.show');
    Route::get('/sekolah/{sekolah}/edit', [SekolahController::class, 'edit'])->name('sekolah.edit');
    Route::put('/sekolah/{sekolah}', [SekolahController::class, 'update'])->name('sekolah.update');
    Route::delete('/sekolah/{sekolah}', [SekolahController::class, 'destroy'])->name('sekolah.destroy');
    Route::get('/verifikasi', [VerificationController::class, 'index'])->name('verifikasi.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Setting Submenu Routes
    Route::get('/settings/profile', [SettingController::class, 'profile'])->name('settings.profile');
    Route::get('/settings/app', [SettingController::class, 'app'])->name('settings.app');
    Route::get('/settings/logs', [SettingController::class, 'logs'])->name('settings.logs');
    Route::get('/settings', [SettingController::class, 'app']);
});
