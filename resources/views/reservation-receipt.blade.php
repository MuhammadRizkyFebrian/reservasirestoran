@extends('layouts.app')

@section('title', 'Resi Reservasi - ' . config('app.name'))

@section('head')
<style>
    .receipt-container {
        max-width: 700px;
        margin: 0 auto;
    }

    .receipt-border {
        border: 1px dashed var(--fallback-bc, oklch(var(--bc)/0.2));
        position: relative;
    }

    .receipt-border::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        right: 0;
        height: 10px;
        background-image: linear-gradient(45deg, transparent 50%, var(--fallback-b2, oklch(var(--b2))) 50%),
            linear-gradient(-45deg, transparent 50%, var(--fallback-b2, oklch(var(--b2))) 50%);
        background-size: 15px 15px;
        background-position: bottom;
    }

    .qr-border {
        border: 5px solid white;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 0.5rem;
        align-items: start;
    }

    .detail-grid>.label {
        font-size: 0.75rem;
        color: var(--fallback-base-content, oklch(var(--bc)/0.7));
    }

    .detail-grid>.value {
        font-weight: 500;
    }

    @media print {
        .no-print {
            display: none !important;
        }

        body,
        html {
            background-color: white !important;
        }

        .receipt-container {
            max-width: 100%;
        }
    }
</style>
@endsection

@section('content')
<!-- Header -->
@component('components.page-header')
@slot('title', 'Resi Reservasi')
@slot('subtitle', 'Bukti reservasi meja Anda')
@endcomponent

<div class="container mx-auto px-4 py-4">
    <div class="receipt-container">
        <!-- Actions -->
        <div class="flex justify-end gap-2 mb-3 no-print">
            <button onclick="window.print()" class="btn btn-sm btn-outline gap-1">
                <i class='bx bx-printer'></i> Cetak
            </button>
            <a href="{{ route('reservation-history') }}" class="btn btn-sm btn-outline gap-1">
                <i class='bx bx-history'></i> Riwayat
            </a>
            <a href="{{ route('home') }}" class="btn btn-sm btn-primary gap-1">
                <i class='bx bx-home'></i> Beranda
            </a>
        </div>

        <!-- Receipt Card -->
        <div class="card bg-base-100 shadow-md">
            <div class="card-body p-3">
                <!-- Header -->
                <div class="flex justify-between items-center border-b pb-2 mb-2">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-8 h-8 rounded-full">
                        <div>
                            <h2 class="font-bold text-lg">Seatify Restaurant</h2>
                            <p class="text-xs text-base-content/70">Jl. Restoran No. 123, Batam</p>
                            <p class="text-xs text-base-content/70">Telp: +62 822 8644 1928</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-success text-sm">{{ strtoupper($status) }}</p>
                        <p class="text-xs text-base-content/70">{{ date('d M Y') }}</p>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Left Column: Details -->
                    <div class="md:col-span-2">
                        <!-- Reservation Info -->
                        <div class="receipt-border rounded-lg p-3 bg-base-200/50 mb-3">
                            <div class="flex justify-between items-center mb-1">
                                <p class="font-bold text-base">{{ $kode_transaksi }}</p>
                                <div class="badge badge-success">{{ $status }}</div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div>
                                    <p class="text-xs text-base-content/70 mb-0.5">Tanggal & Waktu</p>
                                    <p class="font-medium text-sm">{{ $tanggal }}</p>
                                    <p class="font-medium text-sm">{{ $waktu }} WIB</p>
                                </div>
                                <div>
                                    <p class="text-xs text-base-content/70 mb-0.5">Informasi Meja</p>
                                    <p class="font-medium text-sm">{{ $nomor_meja }}</p>
                                    <p class="text-xs">{{ $jumlah_tamu }} orang</p>
                                </div>
                            </div>
                        </div>

                        <!-- Customer & Payment Info -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Customer Info -->
                            <div class="bg-base-200/50 p-3 rounded-lg">
                                <h3 class="font-medium text-sm mb-1.5">Informasi Pemesan</h3>
                                <div class="detail-grid">
                                    <span class="label">Nama</span>
                                    <span class="value text-sm">{{ $nama_pemesan }}</span>
                                    <span class="label">Kontak</span>
                                    <span class="value text-sm">{{ $no_handphone }}</span>
                                </div>
                            </div>

                            <!-- Payment Info -->
                            <div class="bg-base-200/50 p-3 rounded-lg">
                                <h3 class="font-medium text-sm mb-1.5">Rincian Pembayaran</h3>
                                <div class="space-y-1">
                                    <div class="flex justify-between text-xs">
                                        <span>Biaya Reservasi</span>
                                        <span>Rp{{ number_format($harga_meja, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span>Biaya Layanan</span>
                                        <span>Rp{{ number_format($biaya_layanan, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="divider my-1"></div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-bold">Total</span>
                                        <span class="text-sm font-bold">Rp{{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="bg-base-200/50 p-3 rounded-lg mt-3">
                            <p class="text-xs text-base-content/70 mb-0.5">Catatan Khusus</p>
                            <p class="text-xs">{{ $catatan ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Right Column: QR & Terms -->
                    <div class="md:col-span-1">
                        <!-- QR Code -->
                        <div class="bg-base-100 p-3 rounded-lg mb-3 text-center">
                            <div class="qr-border rounded-lg inline-block bg-white mb-1">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ $kode_transaksi }}"
                                    alt="QR Code Reservasi" class="w-28 h-28">
                            </div>
                            <p class="text-xs text-base-content/70">Tunjukkan QR code ini kepada staf kami</p>
                        </div>

                        <!-- Terms (Simplifed) -->
                        <div class="bg-base-200 p-2 rounded-lg text-xs">
                            <h4 class="font-medium mb-1">Ketentuan:</h4>
                            <ul class="space-y-0.5 text-base-content/70 pl-3">
                                <li>Hadir 15 menit sebelum waktu reservasi</li>
                                <li>Berlaku 30 menit setelah waktu reservasi</li>
                                <li>Pembatalan < 24 jam tidak ada refund</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-3 text-xs">
                    <p class="font-medium">Terima kasih telah melakukan reservasi di Seatify Restaurant.</p>
                    <p class="text-base-content/70">Silakan tunjukkan resi ini kepada staf kami saat kedatangan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection