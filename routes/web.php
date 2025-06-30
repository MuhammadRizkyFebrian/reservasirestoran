<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AuthController;
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
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showCustomerLoginForm')->name('login');
    Route::post('/login', 'customerLogin');
    Route::post('/logout', 'customerLogout')->name('logout');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register');
    Route::get('/forgot-password', 'showForgotPasswordForm')->name('password.request');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});

// ==========================
// AUTENTIKASI ADMIN
// ==========================
Route::prefix('admin')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'showAdminLoginForm')->name('admin.login');
    Route::post('/login', 'adminLogin');
    Route::post('/logout', 'adminLogout')->name('admin.logout');
});

// ==========================
// HALAMAN KHUSUS PELANGGAN (AUTH)
// ==========================
Route::middleware('auth:pelanggan')->group(function () {
    // Reservation routes
    Route::get('/reservation', function () {
        $meja = \App\Models\Meja::all();
        return view('reservation', compact('meja'));
    })->name('reservation');
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

    // Payment route
    Route::get('/payment/{kode}', [ReservationController::class, 'payment'])->name('payment');
    Route::post('/payment/confirm', [ReservationController::class, 'confirmPayment'])->name('payment.confirm');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');

    // Reservation history route
    Route::get('/reservation-history', [ReservationController::class, 'history'])->name('reservation-history');
    Route::post('/reservation/cancel/{kode}', [ReservationController::class, 'cancelReservation'])->name('reservation.cancel');
    Route::get('/get-receipt-detail/{kode}', [ReservationController::class, 'getReceiptDetail'])->name('receipt.detail');
    Route::get('/receipt/{kode}', [ReservationController::class, 'showReceipt'])->name('receipt.show');

    // ==========================
    // ULASAN (Review)
    // ==========================
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
    Route::put('/ulasan/update', [UlasanController::class, 'update'])->name('ulasan.update');
    Route::delete('/ulasan/{id}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');

    // ... existing routes ...
    Route::get('/get-reservation-detail/{kode}', [ReservationController::class, 'getReservationDetail']);
    Route::post('/upload-payment-proof', [ReservationController::class, 'uploadPaymentProof']);
    Route::get('/api/check-table-availability', [ReservationController::class, 'checkTableAvailability'])->name('api.check-table-availability');
    // ... existing code ...
});

// ==========================
// ADMIN PANEL (AUTH:STAF)
// ==========================
Route::prefix('admin')->middleware('auth:staf')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::post('/customers/update', [AdminController::class, 'updateCustomer'])->name('admin.customers.update');
    Route::post('/customers/delete', [AdminController::class, 'deleteCustomer'])->name('admin.customers.delete');

    Route::get('/tables', [AdminController::class, 'tables'])->name('admin.tables');
    Route::post('/tables/update', [AdminController::class, 'updateTable'])->name('admin.tables.update');
    Route::post('/tables/create', [AdminController::class, 'createTable'])->name('admin.tables.create');
    Route::post('/tables/delete', [AdminController::class, 'deleteTable'])->name('admin.tables.delete');
    Route::get('/tables/{no_meja}/schedule', [AdminController::class, 'getTableSchedule'])->name('admin.tables.schedule');

    Route::get('/pemesanan', [AdminController::class, 'pemesanan'])->name('admin.pemesanan');
    Route::get('/pemesanan/{kode}', [AdminController::class, 'pemesananDetail'])->name('admin.pemesanan.detail');
    Route::post('/pemesanan/{kode}/konfirmasi', [AdminController::class, 'konfirmasiPemesanan'])->name('admin.pemesanan.konfirmasi');
    Route::post('/pemesanan/{kode}/batalkan', [AdminController::class, 'batalkanPemesanan'])->name('admin.pemesanan.batalkan');

    // Transactions routes
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::get('/transactions/{id}', [AdminController::class, 'transactionDetail'])->name('admin.transactions.detail');
    Route::post('/transactions/{id}/confirm', [AdminController::class, 'confirmTransaction'])->name('admin.transactions.confirm');

    // Halaman menu admin
    Route::get('/menu', [MenuController::class, 'index'])->name('admin.menu');

    // CRUD menu admin
    Route::resource('menus', MenuController::class)->except(['show']);
});
