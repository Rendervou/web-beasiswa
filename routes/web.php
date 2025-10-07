<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeasiswaController;

/**
 * Routes untuk Sistem Pendaftaran Beasiswa
 * dengan IPK Dinamis
 * 
 * @author Your Name
 * @version 2.0
 */

// Halaman Utama
Route::get('/', [BeasiswaController::class, 'index'])->name('beasiswa.home');

// Menu Pilihan Beasiswa
Route::get('/pilihan-beasiswa', [BeasiswaController::class, 'pilihan'])->name('beasiswa.pilihan');

// Menu Daftar Beasiswa
Route::get('/daftar-beasiswa', [BeasiswaController::class, 'daftar'])->name('beasiswa.daftar');
Route::post('/daftar-beasiswa', [BeasiswaController::class, 'store'])->name('beasiswa.store');

// Menu Hasil Pendaftaran
Route::get('/hasil-pendaftaran', [BeasiswaController::class, 'hasil'])->name('beasiswa.hasil');

// Download Berkas
Route::get('/download-berkas/{id}', [BeasiswaController::class, 'downloadBerkas'])->name('beasiswa.download');

// Refresh IPK (untuk testing - opsional, bisa dihapus jika tidak digunakan)
// Route::get('/refresh-ipk', [BeasiswaController::class, 'refreshIpk'])->name('beasiswa.refresh.ipk');