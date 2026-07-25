<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\UserController;

// 1. Dashboard Utama
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);

// 2. Auth Login / Logout
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout']);

// 3. Employee Controller (Data Pegawai PTK)
Route::get('/pegawai', [EmployeeController::class, 'index'])->name('pegawai.index');
Route::get('/pegawai/create', [EmployeeController::class, 'create'])->name('pegawai.create');
Route::get('/pegawai/{id}', [EmployeeController::class, 'show'])->name('pegawai.show');

// 4. School Controller (Kelola Sekolah)
Route::get('/sekolah', [SchoolController::class, 'index'])->name('sekolah.index');

// 5. Verification Controller (Verifikasi Berkas)
Route::get('/verifikasi', [VerificationController::class, 'index'])->name('verifikasi.index');

// 6. User Controller (Manajemen User & Akun System)
Route::get('/users', [UserController::class, 'index'])->name('users.index');
