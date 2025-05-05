<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// Home / Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', function () {
    return view('menu');
})->name('menu');
Route::get('/reservation', function () {
    return view('reservation');
})->name('reservation');
Route::get('/reservation-history', function () {
    return view('reservation-history');
})->name('reservation-history');
Route::get('/payment', function () {
    return view('payment');
})->name('payment');

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
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/customers', function () {
        return view('admin.customers');
    })->name('admin.customers');
    
    Route::get('/tables', function () {
        return view('admin.tables');
    })->name('admin.tables');
    
    Route::get('/pemesanan', function () {
        return view('admin.pemesanan');
    })->name('admin.pemesanan');
    
    Route::get('/transactions', function () {
        return view('admin.riwayat-transaksi');
    })->name('admin.transactions');
});
