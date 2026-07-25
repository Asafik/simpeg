<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SekolahController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pegawai CRUD
    Route::resource('pegawai', PegawaiController::class);

    // Export Data
    Route::get('/export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export/pdf', [ExportController::class, 'exportPdf'])->name('export.pdf');

    // Excel Import
    Route::get('/import-excel', [ExcelImportController::class, 'showImportForm'])->name('excel.import.form');
    Route::post('/import-excel', [ExcelImportController::class, 'processImport'])->name('excel.import.process');

    // Master Sekolah (Admin Dinas Only)
    Route::middleware(['role:ADMIN_DINAS'])->group(function () {
        Route::resource('sekolah', SekolahController::class);
    });
});
