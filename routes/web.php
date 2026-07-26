<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ExportController;

// Public Root URL & Landing Page Sub-Routes
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('landing.index');
})->name('landing.home');

Route::get('/landing', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('landing.index');
})->name('landing');

Route::get('/landing/statistik', function () {
    return view('landing.statistik');
})->name('landing.statistik');

Route::get('/landing/layanan', function () {
    return view('landing.layanan');
})->name('landing.layanan');

Route::get('/landing/cek-ptk', function () {
    return view('landing.cek-ptk');
})->name('landing.cek-ptk');

Route::get('/landing/pengumuman', function () {
    return view('landing.pengumuman');
})->name('landing.pengumuman');

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

    Route::get('/sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
    Route::post('/sekolah', [SekolahController::class, 'store'])->name('sekolah.store');
    Route::get('/sekolah/{sekolah}', [SekolahController::class, 'show'])->name('sekolah.show');
    Route::put('/sekolah/{sekolah}', [SekolahController::class, 'update'])->name('sekolah.update');
    Route::delete('/sekolah/{sekolah}', [SekolahController::class, 'destroy'])->name('sekolah.destroy');
    Route::post('/sekolah/{sekolah}/reset-password', [SekolahController::class, 'resetPassword'])->name('sekolah.reset-password');
    Route::get('/verifikasi', [VerificationController::class, 'index'])->name('verifikasi.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Setting Submenu Routes
    Route::get('/settings/profile', [SettingController::class, 'profile'])->name('settings.profile');
    Route::get('/settings/app', [SettingController::class, 'app'])->name('settings.app');
    Route::get('/settings/logs', [SettingController::class, 'logs'])->name('settings.logs');
    Route::get('/settings', [SettingController::class, 'app']);
});
