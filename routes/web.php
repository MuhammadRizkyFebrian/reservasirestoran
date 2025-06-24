<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PelangganAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UlasanController;

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
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
    Route::delete('/ulasan/{id}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
    Route::put('/ulasan/update', [UlasanController::class, 'update'])->name('ulasan.update');
});

// ==========================
// ADMIN PANEL
// ==========================
Route::prefix('admin')->group(function () {
    Route::get('/login', [PelangganAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [PelangganAuthController::class, 'login']);
    Route::post('/logout', [PelangganAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:staf')->group(function () {
        Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
        Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
        Route::post('/customers/update', [AdminController::class, 'updateCustomer'])->name('admin.customers.update');
        Route::post('/customers/delete', [AdminController::class, 'deleteCustomer'])->name('admin.customers.delete');
        Route::get('/tables', [AdminController::class, 'tables'])->name('admin.tables');
        Route::post('/tables/update', [AdminController::class, 'updateTable'])->name('admin.tables.update');
        Route::view('/pemesanan', 'admin.pemesanan')->name('admin.pemesanan');
        Route::view('/transactions', 'admin.riwayat-transaksi')->name('admin.transactions');

        // Halaman menu admin
        Route::get('/menu', [MenuController::class, 'index'])->name('admin.menu');

        // CRUD menu admin
        Route::resource('menus', MenuController::class)->except(['show']);
    });
});
