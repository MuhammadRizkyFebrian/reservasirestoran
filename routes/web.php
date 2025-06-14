<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PelangganAuthController;

// ==========================
// LANDING DAN MENU UMUM
// ==========================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'menuPelanggan'])->name('menu');

// ==========================
// AUTENTIKASI PELANGGAN
// ==========================
Route::get('/login', [PelangganAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [PelangganAuthController::class, 'login']);
Route::post('/logout', [PelangganAuthController::class, 'logout'])->name('logout');

Route::get('/register', [PelangganAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [PelangganAuthController::class, 'register']);

Route::get('/forgot-password', [PelangganAuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/reset-password', [PelangganAuthController::class, 'resetPassword'])->name('password.update');

// ==========================
// HALAMAN YANG WAJIB LOGIN
// ==========================
Route::middleware('auth:pelanggan')->group(function () {
    Route::view('/reservation', 'reservation')->name('reservation');
    Route::view('/reservation-history', 'reservation-history')->name('reservation-history');
    Route::view('/payment', 'payment')->name('payment');
    Route::view('/profile', 'profile')->name('profile');
});

// ==========================
// ADMIN PANEL
// ==========================
Route::prefix('auth:staf')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/customers', 'admin.customers')->name('admin.customers');
    Route::view('/tables', 'admin.tables')->name('admin.tables');
    Route::view('/pemesanan', 'admin.pemesanan')->name('admin.pemesanan');
    Route::view('/transactions', 'admin.riwayat-transaksi')->name('admin.transactions');

    // Halaman menu admin
    Route::get('/menu', [MenuController::class, 'index'])->name('admin.menu');

    // CRUD menu admin
    Route::resource('menus', MenuController::class)->except(['show']);
});
