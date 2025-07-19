<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pelanggan\HomeController;
use App\Http\Controllers\Staf_Restoran\MenuController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Staf_Restoran\AdminController;
use App\Http\Controllers\Pelanggan\ProfileController;
use App\Http\Controllers\Pelanggan\ReservationController;
use App\Http\Controllers\Pelanggan\UlasanController;
use App\Models\Staf_Restoran\Meja;

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
    Route::get('/daftar', 'showRegisterForm')->name('register');
    Route::post('/daftar', 'register');
    Route::get('/lupa-sandi', 'showForgotPasswordForm')->name('password.request');
    Route::post('/lupa-sandi', 'sendResetOtp')->name('password.email');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});

// ==========================
// AUTENTIKASI ADMIN
// ==========================
Route::prefix('staf')->controller(AuthController::class)->group(function () {
    Route::post('/logout', 'adminLogout')->name('staf.logout');
});

// ==========================
// HALAMAN KHUSUS PELANGGAN (AUTH)
// ==========================
Route::middleware('auth:pelanggan')->group(function () {
    // Reservation routes
    Route::get('/reservation', function () {
        $meja = Meja::all();
        return view('pelanggan.reservation', compact('meja'));
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
Route::prefix('staf')->middleware('auth:staf')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('staf.dashboard');

    Route::get('/pelanggan', [AdminController::class, 'customers'])->name('staf.customers');
    Route::post('/pelanggan/update', [AdminController::class, 'updateCustomer'])->name('staf.customers.update');
    Route::post('/pelanggan/delete', [AdminController::class, 'deleteCustomer'])->name('staf.customers.delete');

    Route::get('/meja', [AdminController::class, 'tables'])->name('staf.tables');
    Route::post('/meja/update', [AdminController::class, 'updateTable'])->name('staf.tables.update');
    Route::post('/meja/create', [AdminController::class, 'createTable'])->name('staf.tables.create');
    Route::post('/meja/delete', [AdminController::class, 'deleteTable'])->name('staf.tables.delete');
    Route::get('/meja/{no_meja}/schedule', [AdminController::class, 'getTableSchedule'])->name('staf.tables.schedule');

    Route::get('/pemesanan', [AdminController::class, 'pemesanan'])->name('staf.pemesanan');
    Route::get('/pemesanan/{kode}', [AdminController::class, 'pemesananDetail'])->name('staf.pemesanan.detail');
    Route::post('/pemesanan/{kode}/konfirmasi', [AdminController::class, 'konfirmasiPemesanan'])->name('staf.pemesanan.konfirmasi');
    Route::post('/pemesanan/{kode}/batalkan', [AdminController::class, 'batalkanPemesanan'])->name('staf.pemesanan.batalkan');

    // Transactions routes
    Route::get('/transaksi', [AdminController::class, 'transactions'])->name('staf.transactions');
    Route::get('/transaksi/{id}', [AdminController::class, 'transactionDetail'])->name('staf.transactions.detail');
    Route::post('/transaksi/{id}/confirm', [AdminController::class, 'confirmTransaction'])->name('staf.transactions.confirm');

    // Halaman menu admin
    Route::get('/menu', [MenuController::class, 'index'])->name('staf.menu');

    // CRUD menu admin
    Route::resource('menus', MenuController::class)->except(['show']);
});

Route::get('/meja', function () {
    $meja = Meja::all();
    return response()->json($meja);
});
