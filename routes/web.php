<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PelangganAuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UlasanController;

// ==========================
// LANDING DAN MENU UMUM
// ==========================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'menuPelanggan'])->name('menu');

// ==========================
// AUTENTIKASI PELANGGAN
// ==========================
Route::controller(PelangganAuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register');
    Route::get('/forgot-password', 'showForgotPasswordForm')->name('password.request');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});

// ==========================
// AUTENTIKASI ADMIN
// ==========================
Route::prefix('admin')->controller(AdminAuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('admin.login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('admin.logout');
});

// ==========================
// HALAMAN KHUSUS PELANGGAN (AUTH)
// ==========================
Route::middleware('auth:pelanggan')->group(function () {
    // Reservation routes
    Route::get('/reservation', function() {
        return view('reservation');
    })->name('reservation');
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

    // Payment route
    Route::get('/payment/{kode}', [ReservationController::class, 'payment'])->name('payment');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');

    // Reservation history route
    Route::get('/reservation-history', [ProfileController::class, 'reservationHistory'])->name('reservation-history');

    // ==========================
    // ULASAN (Review)
    // ==========================
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
    Route::put('/ulasan/update', [UlasanController::class, 'update'])->name('ulasan.update');
    Route::delete('/ulasan/{id}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
});

// ==========================
// ADMIN PANEL (AUTH:STAF)
// ==========================
Route::prefix('admin')->middleware('auth:staf')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::post('/customers/update', [AdminController::class, 'updateCustomer'])->name('admin.customers.update');
    Route::post('/customers/delete', [AdminController::class, 'deleteCustomer'])->name('admin.customers.delete');

    Route::get('/tables', [AdminController::class, 'tables'])->name('admin.tables');
    Route::post('/tables/update', [AdminController::class, 'updateTable'])->name('admin.tables.update');

    Route::get('/pemesanan', function () {
        return view('admin.pemesanan');
    })->name('admin.pemesanan');

    Route::get('/transactions', function () {
        return view('admin.riwayat-transaksi');
    })->name('admin.transactions');

    // Halaman menu admin
    Route::get('/menu', [MenuController::class, 'index'])->name('admin.menu');

    // CRUD menu admin
    Route::resource('menus', MenuController::class)->except(['show']);
});
