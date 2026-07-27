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
use App\Http\Controllers\ExportController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\AnnouncementController;

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

    // Pegawai Management & Data Exchange Routes
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/template/download', [PegawaiController::class, 'downloadTemplate'])->name('pegawai.template');
    Route::post('/pegawai/import', [PegawaiController::class, 'import'])->name('pegawai.import');
    Route::post('/pegawai/bulk-delete', [PegawaiController::class, 'bulkDestroy'])->name('pegawai.bulk-destroy');
    Route::get('/pegawai/export/excel', [ExportController::class, 'exportExcel'])->name('pegawai.export.excel');
    Route::get('/pegawai/export/pdf', [ExportController::class, 'exportPdf'])->name('pegawai.export.pdf');
    Route::get('/pegawai/{pegawai}', [PegawaiController::class, 'show'])->name('pegawai.show');
    Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
    Route::get('/pegawai/{pegawai}/riwayat', [RiwayatController::class, 'pegawai'])->name('pegawai.riwayat');

    Route::get('/sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
    Route::get('/sekolah/create', [SekolahController::class, 'create'])->name('sekolah.create');
    Route::post('/sekolah', [SekolahController::class, 'store'])->name('sekolah.store');
    Route::get('/sekolah/{sekolah}', [SekolahController::class, 'show'])->name('sekolah.show');
    Route::get('/sekolah/{sekolah}/edit', [SekolahController::class, 'edit'])->name('sekolah.edit');
    Route::put('/sekolah/{sekolah}', [SekolahController::class, 'update'])->name('sekolah.update');
    Route::delete('/sekolah/{sekolah}', [SekolahController::class, 'destroy'])->name('sekolah.destroy');
    Route::post('/sekolah/{sekolah}/reset-password', [SekolahController::class, 'resetPassword'])->name('sekolah.reset-password');
    Route::get('/sekolah/{sekolah}/riwayat', [RiwayatController::class, 'sekolah'])->name('sekolah.riwayat');
    Route::get('/verifikasi', [VerificationController::class, 'index'])->name('verifikasi.index');
    Route::get('/verifikasi/{pegawai}', [VerificationController::class, 'show'])->name('verifikasi.show');
    Route::get('/verifikasi/{pegawai}/tinjau', [VerificationController::class, 'tinjau'])->name('verifikasi.tinjau');
    Route::post('/verifikasi/{pegawai}/status', [VerificationController::class, 'updateStatus'])->name('verifikasi.update-status');
    Route::put('/verifikasi/{pegawai}/status', [VerificationController::class, 'updateStatus']);
    Route::get('/admin/pengumuman', [AnnouncementController::class, 'index'])->name('pengumuman.index');
    Route::get('/admin/pengumuman/create', [AnnouncementController::class, 'create'])->name('pengumuman.create');
    Route::post('/admin/pengumuman', [AnnouncementController::class, 'store'])->name('pengumuman.store');
    Route::get('/admin/pengumuman/{id}/edit', [AnnouncementController::class, 'edit'])->name('pengumuman.edit');
    Route::put('/admin/pengumuman/{id}', [AnnouncementController::class, 'update'])->name('pengumuman.update');
    Route::delete('/admin/pengumuman/{id}', [AnnouncementController::class, 'destroy'])->name('pengumuman.destroy');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

    // Setting Submenu Routes
    Route::get('/settings/profile', [SettingController::class, 'profile'])->name('settings.profile');
    Route::post('/settings/profile', [SettingController::class, 'updateProfile'])->name('settings.profile.update');
    Route::post('/settings/password', [SettingController::class, 'updatePassword'])->name('settings.password.update');
    Route::get('/settings/app', [SettingController::class, 'app'])->name('settings.app');
    Route::post('/settings/app', [SettingController::class, 'updateApp'])->name('settings.app.update');
    Route::get('/settings/logs', [SettingController::class, 'logs'])->name('settings.logs');
    Route::get('/settings', [SettingController::class, 'profile']);
});
