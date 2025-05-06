@extends('layouts.app')

@section('title', 'Pemilihan Meja - ' . config('app.name'))

@section('head')
    @include('components.reservation.reservation-styles')
@endsection

@section('content')
    <!-- Header -->
    @component('components.page-header')
        @slot('title', 'Pemilihan Meja')
        @slot('subtitle', 'Pilih meja yang tersedia untuk pengalaman bersantap terbaik Anda')
    @endcomponent

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Table Selection -->
        <div class="card bg-base-200 shadow-xl mb-6 max-w-5xl mx-auto">
            <div class="card-body p-4">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-3">
                    <h2 class="card-title text-lg font-bold">Denah Meja Restoran</h2>
                    <button id="reservationFormBtn" class="btn btn-primary btn-sm mt-2 sm:mt-0">
                        <i class='bx bx-calendar-edit mr-1'></i> Buat Reservasi
                    </button>
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
                        <img src="{{ asset('images/restaurant_floor_plan (1).png') }}" alt="Denah Restoran" class="w-10/12 h-auto rounded-lg shadow-md">
                    </div>
                    
                    <!-- Tombol Meja -->
                    <div>
                        <h3 class="font-bold text-base mb-2">Pilih Meja</h3>
                        
                        <!-- Area 1: Meja Bundar -->
                        <div class="mb-2">
                            <h4 class="font-semibold text-sm mb-1">Meja Bundar</h4>
                            <div class="grid grid-cols-4 gap-2">
                                <button class="table-btn available" data-table="1" data-price="50000">Meja 1</button>
                                <button class="table-btn available" data-table="2" data-price="50000">Meja 2</button>
                                <button class="table-btn available" data-table="3" data-price="50000">Meja 3</button>
                                <button class="table-btn reserved" data-table="4" data-price="50000">Meja 4</button>
                            </div>
                        </div>
                        
                        <!-- Area 2: Meja Tengah -->
                        <div class="mb-2">
                            <h4 class="font-semibold text-sm mb-1">Meja Tengah</h4>
                            <div class="grid grid-cols-4 gap-2">
                                <button class="table-btn available" data-table="5" data-price="65000">Meja 5</button>
                                <button class="table-btn available" data-table="6" data-price="65000">Meja 6</button>
                                <button class="table-btn reserved" data-table="7" data-price="65000">Meja 7</button>
                                <button class="table-btn available" data-table="8" data-price="65000">Meja 8</button>
                            </div>
                        </div>
                        
                        <!-- Area 3: Meja Persegi Panjang -->
                        <div class="mb-2">
                            <h4 class="font-semibold text-sm mb-1">Meja Persegi Panjang</h4>
                            <div class="grid grid-cols-4 gap-2">
                                <button class="table-btn available" data-table="9" data-price="75000">Meja 9</button>
                                <button class="table-btn available" data-table="10" data-price="75000">Meja 10</button>
                                <button class="table-btn reserved" data-table="11" data-price="75000">Meja 11</button>
                                <button class="table-btn available" data-table="12" data-price="75000">Meja 12</button>
                            </div>
                        </div>
                        
                        <!-- Area 4: Meja VIP -->
                        <div>
                            <h4 class="font-semibold text-sm mb-1">Meja VIP</h4>
                            <div class="grid grid-cols-4 gap-2">
                                <button class="table-btn available" data-table="13" data-price="120000">VIP-1</button>
                                <button class="table-btn reserved" data-table="14" data-price="120000">VIP-2</button>
                                <div class="col-span-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Summary -->
                <div class="mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center">
                    <div>
                        <h3 class="font-bold text-base">Meja Dipilih: <span id="tableSummary" class="text-primary">Belum ada meja yang dipilih</span></h3>
                    </div>
                    <div class="mt-2 sm:mt-0">
                        <button id="openReservationModalBtn" class="btn btn-primary btn-sm" disabled>Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    @include('components.reservation.reservation-modal')
    @include('components.reservation.success-modal')
@endsection

@section('modals')
    @include('components.terms-modal')
@endsection

@section('scripts')
    @include('components.reservation.reservation-scripts')
@endsection 