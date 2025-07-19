@extends('layouts.app')

@section('title', 'Reservasi Meja - ' . config('app.name'))

@section('head')
<style>
    .table-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 3rem;
        height: 3rem;
        font-weight: 600;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }

    .table-btn.available {
        background-color: #86efac;
        border: 1px solid #22c55e;
    }

    .table-btn.reserved {
        background-color: #fca5a5;
        border: 1px solid #ef4444;
        cursor: not-allowed;
        opacity: 0.8;
    }

    .table-btn.selected {
        background-color: #93c5fd;
        border: 1px solid #3b82f6;
        transform: scale(1.05);
    }

    .table-btn.available:hover {
        transform: scale(1.05);
    }

    .table-btn .tooltip {
        visibility: hidden;
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        text-align: center;
        padding: 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        white-space: nowrap;
        z-index: 10;
        margin-bottom: 0.25rem;
    }

    .table-btn:hover .tooltip {
        visibility: visible;
    }
</style>
@include('components.reservation.reservation-styles')
@endsection

@section('content')
<!-- Header -->
@component('components.page-header')
@slot('title', 'Reservasi Meja')
@slot('subtitle', 'Pilih waktu kunjungan dan meja yang tersedia untuk pengalaman bersantap terbaik Anda')
@endcomponent

<!-- Main Content -->
<div class="container mx-auto px-4 py-8">
    <!-- Datetime Selection -->
    <div class="card bg-base-200 shadow-xl mb-6 max-w-5xl mx-auto">
        <div class="card-body p-4">
            <h2 class="card-title text-lg font-bold mb-4">Pilih Waktu Kunjungan</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tanggal Kunjungan</span>
                    </label>
                    <input type="date" id="reservationDate" class="input input-bordered" required>
                    <label class="label">
                        <span class="label-text-alt text-base-content/70">*Pemesanan hanya tersedia untuk 7 hari ke depan</span>
                    </label>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Waktu Kunjungan</span>
                    </label>
                    <select id="reservationTime" class="select select-bordered" required>
                        <option value="" disabled selected>Pilih Waktu</option>
                        <option value="11:00">11:00</option>
                        <option value="13:00">13:00</option>
                        <option value="15:00">15:00</option>
                        <option value="17:00">17:00</option>
                        <option value="19:00">19:00</option>
                        <option value="21:00">21:00</option>
                    </select>
                    <label class="label">
                        <span class="label-text-alt text-base-content/70">*Pemesanan harus dilakukan minimal 20 menit sebelum jadwal yang dipilih</span>
                    </label>
                </div>
            </div>

            <div class="mt-4">
                <button id="checkAvailabilityBtn" class="btn btn-primary text-white" disabled>
                    Cek Ketersediaan Meja
                </button>
            </div>
        </div>
    </div>

    <!-- Table Selection (Initially Hidden) -->
    <div id="tableSelectionSection" class="card bg-base-200 shadow-xl mb-6 max-w-5xl mx-auto hidden">
        <div class="card-body p-4">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-3">
                <h2 class="card-title text-lg font-bold">Denah Meja Restoran</h2>
            </div>

            <div class="mb-3">
                <div class="flex items-center gap-3 mb-2 flex-wrap status-legend text-sm">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-[#86efac] border border-[#22c55e] rounded-sm mr-1"></div>
                        <span>Tersedia</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-[#fca5a5] border border-[#ef4444] rounded-sm mr-1"></div>
                        <span>Dipesan</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-[#93c5fd] border border-[#3b82f6] rounded-sm mr-1"></div>
                        <span>Dipilih</span>
                    </div>
                </div>
            </div>

            <!-- Layout Grid untuk Denah dan Pilihan Meja -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Gambar PNG Denah Restoran -->
                <div class="flex justify-center items-center">
                    <img src="{{ asset('images/denah.png') }}" alt="Denah Restoran" class="w-10/12 h-auto rounded-lg shadow-md">
                </div>

                <!-- Daftar Meja -->
                <div id="tableList" class="space-y-6">
                    <!-- Daftar meja akan diisi melalui JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
@include('components.reservation.reservation-modal')
@if (session('kode_transaksi'))
@include('components.reservation.success-modal', ['kode_transaksi' => session('kode_transaksi')])
@endif

@endsection

@section('modals')
@include('components.terms-modal')
@endsection

@section('scripts')
@include('components.reservation.reservation-scripts')
@endsection