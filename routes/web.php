<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OperatorDashboardController;
use App\Http\Controllers\OperatorPegawaiController;
use App\Http\Controllers\OperatorSekolahController;
use App\Http\Controllers\OperatorVerifikasiController;
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

// Secure File Serving Route (Bypasses Hostinger physical /storage 403 block)
$fileServerHandler = function ($path) {
    $path = str_replace('..', '', $path);
    $cleanPath = preg_replace('#^(storage/|public/|app/public/|app/)#', '', ltrim($path, '/'));

    $possiblePaths = [
        storage_path('app/public/' . $cleanPath),
        storage_path('app/' . $cleanPath),
        storage_path($cleanPath),
        public_path('storage/' . $cleanPath),
        public_path($cleanPath),
        base_path('storage/app/public/' . $cleanPath),
        base_path('storage/app/' . $cleanPath),
    ];

    $filePath = null;
    foreach ($possiblePaths as $candidate) {
        if (file_exists($candidate) && !is_dir($candidate)) {
            $filePath = $candidate;
            break;
        }
    }

    if (!$filePath) {
        abort(404, 'File tidak ditemukan di server.');
    }

    $mimeType = @mime_content_type($filePath) ?: 'application/octet-stream';
    return response()->file($filePath, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
};

Route::get('/files/{path}', $fileServerHandler)->where('path', '.*')->name('files.serve');
Route::get('/storage/{path}', $fileServerHandler)->where('path', '.*');

// Production System Optimization & Cache Clear Route
Route::get('/optimize-clear', function () {
    try {
        Artisan::call('optimize:clear');
        $output = Artisan::output();
        
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('cache:clear');

        return '<div style="font-family: system-ui, sans-serif; max-width: 600px; margin: 50px auto; padding: 30px; border-radius: 16px; background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);">'
            . '<h2 style="margin-top:0; color: #15803d; font-size: 20px; display: flex; items-center: center; gap: 8px;">⚡ System Optimization Cache Cleared!</h2>'
            . '<p style="font-size: 14px; color: #166534; line-height: 1.5;">Seluruh cache aplikasi Laravel (config, routes, views, event, dan cache terkompilasi) berhasil dibersihkan untuk lingkungan produksi.</p>'
            . '<pre style="background: #ffffff; padding: 15px; border-radius: 8px; border: 1px solid #dcfce7; font-size: 12px; overflow-x: auto; color: #14532d;">' . htmlspecialchars($output ?: "optimize:clear completed successfully.") . '</pre>'
            . '<div style="margin-top: 20px; display: flex; gap: 10px;">'
            . '<a href="' . url('/dashboard') . '" style="background: #15803d; color: #fff; text-decoration: none; padding: 10px 18px; border-radius: 8px; font-weight: bold; font-size: 13px; display: inline-block;">Ke Dashboard Admin</a>'
            . '<a href="' . url('/pegawai/create') . '" style="background: #fff; color: #15803d; border: 1px solid #bbf7d0; text-decoration: none; padding: 10px 18px; border-radius: 8px; font-weight: bold; font-size: 13px; display: inline-block;">Ke Form Pegawai</a>'
            . '</div>'
            . '</div>';
    } catch (\Exception $e) {
        return '<div style="font-family: system-ui, sans-serif; max-width: 600px; margin: 50px auto; padding: 30px; border-radius: 16px; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;">'
            . '<h2 style="margin-top:0; color: #dc2626; font-size: 20px;">❌ Error Clearing Cache</h2>'
            . '<p style="font-size: 14px;">' . htmlspecialchars($e->getMessage()) . '</p>'
            . '</div>';
    }
})->name('system.optimize-clear');

Route::get('/clear-cache', function () {
    return redirect('/optimize-clear');
});

Route::get('/optimize', function () {
    return redirect('/optimize-clear');
});

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
    Route::get('/operator/dashboard', [OperatorDashboardController::class, 'index'])->name('operator.dashboard');

    // Dedicated Operator Pegawai Routes
    Route::get('/operator/pegawai', [OperatorPegawaiController::class, 'index'])->name('operator.pegawai.index');
    Route::get('/operator/pegawai/create', [OperatorPegawaiController::class, 'create'])->name('operator.pegawai.create');
    Route::post('/operator/pegawai', [OperatorPegawaiController::class, 'store'])->name('operator.pegawai.store');
    Route::post('/operator/pegawai/bulk-delete', [OperatorPegawaiController::class, 'bulkDestroy'])->name('operator.pegawai.bulk-destroy');
    Route::get('/operator/pegawai/{pegawai}', [OperatorPegawaiController::class, 'show'])->name('operator.pegawai.show');
    Route::get('/operator/pegawai/{pegawai}/edit', [OperatorPegawaiController::class, 'edit'])->name('operator.pegawai.edit');
    Route::put('/operator/pegawai/{pegawai}', [OperatorPegawaiController::class, 'update'])->name('operator.pegawai.update');
    Route::delete('/operator/pegawai/{pegawai}', [OperatorPegawaiController::class, 'destroy'])->name('operator.pegawai.destroy');

    // Dedicated Operator Sekolah Routes
    Route::get('/operator/sekolah', [OperatorSekolahController::class, 'index'])->name('operator.sekolah.index');
    Route::get('/operator/sekolah/edit', [OperatorSekolahController::class, 'edit'])->name('operator.sekolah.edit');
    Route::put('/operator/sekolah', [OperatorSekolahController::class, 'update'])->name('operator.sekolah.update');

    // Dedicated Operator Verifikasi Routes
    Route::get('/operator/verifikasi', [OperatorVerifikasiController::class, 'index'])->name('operator.verifikasi.index');
    Route::post('/operator/verifikasi/{id}/upload', [OperatorVerifikasiController::class, 'upload'])->name('operator.verifikasi.upload');

    // Pegawai Management & Data Exchange Routes (Accessible by both Admin and Operator)
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

    // Admin Dinas Only Routes
    Route::middleware(['role:ADMIN_DINAS'])->group(function () {
        Route::get('/sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
        Route::get('/sekolah/create', [SekolahController::class, 'create'])->name('sekolah.create');
        Route::post('/sekolah', [SekolahController::class, 'store'])->name('sekolah.store');
        Route::get('/sekolah/{sekolah}', [SekolahController::class, 'show'])->name('sekolah.show');
        Route::get('/sekolah/{sekolah}/edit', [SekolahController::class, 'edit'])->name('sekolah.edit');
        Route::put('/sekolah/{sekolah}', [SekolahController::class, 'update'])->name('sekolah.update');
        Route::delete('/sekolah/{sekolah}', [SekolahController::class, 'destroy'])->name('sekolah.destroy');
        Route::post('/sekolah/{sekolah}/reset-password', [SekolahController::class, 'resetPassword'])->name('sekolah.reset-password');
        Route::get('/sekolah/{sekolah}/riwayat', [RiwayatController::class, 'sekolah'])->name('sekolah.riwayat');

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
    });

    // Verification Routes (Accessible by both Admin and Operator, but Operator has limited view)
    Route::get('/verifikasi', [VerificationController::class, 'index'])->name('verifikasi.index');
    Route::post('/verifikasi/{id}', [VerificationController::class, 'verify'])->name('verifikasi.verify');
    Route::get('/verifikasi/{pegawai}', [VerificationController::class, 'show'])->name('verifikasi.show');
    Route::get('/verifikasi/{pegawai}/tinjau', [VerificationController::class, 'tinjau'])->name('verifikasi.tinjau');

    // Setting Submenu Routes (Accessible by both Admin and Operator)
    Route::get('/settings/profile', [SettingController::class, 'profile'])->name('settings.profile');
    Route::post('/settings/profile', [SettingController::class, 'updateProfile'])->name('settings.profile.update');
    Route::post('/settings/password', [SettingController::class, 'updatePassword'])->name('settings.password.update');
    Route::get('/settings/app', [SettingController::class, 'app'])->name('settings.app');
    Route::post('/settings/app', [SettingController::class, 'updateApp'])->name('settings.app.update');
    Route::get('/settings/logs', [SettingController::class, 'logs'])->name('settings.logs');
    Route::get('/settings', [SettingController::class, 'profile']);
});
