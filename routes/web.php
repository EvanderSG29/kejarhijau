<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CatatanTanamanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanSampahController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // Dashboard (admin diarahkan ke admin.dashboard)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Khusus Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::patch('/members/{user}/toggle-akses', [AdminController::class, 'toggleAkses'])->name('members.toggle-akses');
    });

    // Admin (selalu boleh) + Member (wajib status_akses = true)
    Route::middleware(['role:admin,member', 'akses.crud'])->group(function () {
        Route::resource('laporan-sampah', LaporanSampahController::class)->except('show');
        Route::resource('catatan-tanaman', CatatanTanamanController::class)->except('show');
    });
});

require __DIR__.'/auth.php';
