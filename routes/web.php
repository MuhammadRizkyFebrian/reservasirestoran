<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;

// Home / Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route untuk menu pelanggan, pakai controller agar $makanan & $minuman terisi
Route::get('/menu', [MenuController::class, 'menuPelanggan'])->name('menu');

// Route static lainnya
Route::view('/reservation', 'reservation')->name('reservation');
Route::view('/reservation-history', 'reservation-history')->name('reservation-history');
Route::view('/payment', 'payment')->name('payment');
Route::view('/profile', 'profile')->name('profile');

// Route autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route registrasi
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Route reset password
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Route profil
Route::get('/profile', function () {
    return view('profile');
})->name('profile');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/customers', 'admin.customers')->name('admin.customers');
    Route::view('/tables', 'admin.tables')->name('admin.tables');
    Route::view('/pemesanan', 'admin.pemesanan')->name('admin.pemesanan');
    Route::view('/transactions', 'admin.riwayat-transaksi')->name('admin.transactions');

    // Admin menu page
    Route::get('/menu', [MenuController::class, 'index'])->name('admin.menu');

    // Resource routes untuk CRUD menu
    Route::resource('menus', MenuController::class)->except(['show']);
});