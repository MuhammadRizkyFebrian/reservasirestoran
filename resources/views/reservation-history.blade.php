@extends('layouts.app', ['noFooter' => true])

@section('title', 'Riwayat Reservasi - ' . config('app.name'))

@section('styles')
<style>
.reservation-card {
    background-color: var(--fallback-b2,oklch(var(--b2)));
    border-radius: 0.75rem;
    padding: 1.25rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.06);
    transition: transform 0.3s ease;
}

.reservation-card:hover {
    transform: translateY(-3px);
}

.reservation-filter {
    background-color: var(--fallback-b2,oklch(var(--b2)));
    border-radius: 0.75rem;
    padding: 1.25rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.06);
}

.profile-sidebar {
    background-color: var(--fallback-b1,oklch(var(--b1)));
    border-radius: 1rem;
    padding: 2rem;
    height: 100%;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.profile-image {
    width: 140px;
    height: 140px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid var(--fallback-primary,oklch(var(--p)));
}

.edit-button {
    position: absolute;
    bottom: 0;
    right: 10px;
    background-color: var(--fallback-primary,oklch(var(--p)));
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.nav-item {
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    margin-bottom: 0.5rem;
    transition: all 0.2s ease;
    cursor: pointer;
    display: flex;
    align-items: center;
}

.nav-item:hover, .nav-item.active {
    background-color: var(--fallback-primary,oklch(var(--p)));
    color: var(--fallback-primary-content,oklch(var(--pc)));
}

.nav-item i {
    margin-right: 0.75rem;
    font-size: 1.2rem;
}

@media (max-width: 768px) {
    .profile-sidebar {
        margin-bottom: 2rem;
    }
}
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Sidebar Profile -->
        <div class="md:col-span-1">
            <div class="profile-sidebar">
                <div class="flex flex-col items-center mb-6">
                    <div class="relative mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ auth('pelanggan')->user()->username ?? 'User' }}&background=random&size=140" alt="Profile" id="profileAvatar" class="profile-image">
                        <label for="avatarUpload" class="edit-button">
                            <i class='bx bx-plus'></i>
                            <input type="file" id="avatarUpload" class="hidden" accept="image/*" />
                        </label>
                    </div>
                    <h2 class="text-xl font-bold mb-3">{{ auth('pelanggan')->user()->username ?? 'User' }}</h2>
                    <div class="flex flex-col items-center space-y-2 text-center">
                        <div class="flex items-center">
                            <i class='bx bx-envelope text-base-content/70 mr-2'></i>
                            <span class="text-sm" id="displayEmail">{{ auth('pelanggan')->user()->email ?? 'user@example.com' }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class='bx bx-phone text-base-content/70 mr-2'></i>
                            <span class="text-sm" id="displayPhone">{{ auth('pelanggan')->user()->nomor_handphone ?? '+62 000 0000 0000' }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('profile') }}" class="nav-item">
                        <i class='bx bx-user'></i>
                        <span>Profil</span>
                    </a>
                    <a href="{{ route('reservation-history') }}" class="nav-item active">
                        <i class='bx bx-history'></i>
                        <span>Riwayat Pemesanan</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-item w-full text-left">
                            <i class='bx bx-log-out'></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="md:col-span-3">
            <div class="flex justify-between items-center mb-3">
                <h1 class="text-xl sm:text-2xl font-bold">Riwayat Reservasi</h1>
            </div>

            <!-- Filter Section -->
            <div class="reservation-filter mb-6">
                <div class="flex flex-col sm:flex-row gap-4 sm:items-end">
                    <div class="form-control flex-1">
                        <label class="label">
                            <span class="label-text">Status</span>
                        </label>
                        <select class="select select-bordered w-full" id="statusFilter">
                            <option value="all">Semua Status</option>
                            <option value="completed">Selesai</option>
                            <option value="scheduled">Terjadwal</option>
                            <option value="pending">Menunggu Konfirmasi</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>

                    <div class="form-control flex-1">
                        <label class="label">
                            <span class="label-text">Tanggal</span>
                        </label>
                        <select class="select select-bordered w-full" id="dateFilter">
                            <option value="all">Semua Tanggal</option>
                            <option value="this-month">Bulan Ini</option>
                            <option value="last-month">Bulan Lalu</option>
                            <option value="this-year">Tahun Ini</option>
                        </select>
                    </div>

                    <div class="form-control flex-1">
                        <button class="btn btn-primary text-white" id="filterButton">
                            <i class='bx bx-filter-alt mr-2'></i> Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reservations List -->
            <div id="reservationsList">
                @forelse ($reservasi as $item)
                    @php
                        $status = 'pending';
                        $statusLabel = 'Menunggu Konfirmasi';
                        $badgeClass = 'badge-warning';

                        if (strtotime($item->jadwal) < now()->timestamp) {
                            $status = 'completed';
                            $statusLabel = 'Selesai';
                            $badgeClass = 'badge-success';
                        }

                        $meja = 'Meja ' . ($item->no_meja ?? '0');
                        $tanggal = \Carbon\Carbon::parse($item->jadwal)->translatedFormat('d M Y');
                        $jam = \Carbon\Carbon::parse($item->jadwal)->format('H:i');
                    @endphp

                    <div class="reservation-card" data-status="{{ $status }}" data-date="{{ $item->jadwal }}">
                        <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-2">
                            <div class="mb-2 sm:mb-0 max-w-full overflow-hidden">
                                <h3 class="font-bold text-lg truncate">Reservasi-{{ $item->id_pemesanan }}</h3>
                                <p class="text-sm text-base-content/70">{{ $tanggal }} - {{ $jam }}</p>
                            </div>
                            <span class="badge {{ $badgeClass }} whitespace-nowrap shrink-0 px-2 py-3">{{ $statusLabel }}</span>
                        </div>

                        <div class="divider my-2"></div>

                        <div class="mb-2">
                            <p class="text-sm text-base-content/70">Meja</p>
                            <p class="font-medium break-words">{{ $meja }} ({{ $item->jumlah_tamu }} orang)</p>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                            <p class="font-bold mb-2 sm:mb-0 break-words">Total: Rp{{ number_format(25000 + 15000, 0, ',', '.') }}</p>
                            <div class="flex flex-wrap gap-2 mt-3 justify-between">
                                <div class="flex gap-2 flex-grow">
                                    @if(isset($item->kode))
                                        <a href="{{ route('payment', ['kode' => $item->kode]) }}" class="btn btn-sm btn-primary text-white flex-1 sm:flex-none">
                                            <i class='bx bx-credit-card'></i>
                                            <span class="hidden xs:inline">Lihat Pembayaran</span>
                                        </a>
                                    @endif
                                    @if($status !== 'cancelled' && $status !== 'completed')
                                        <button class="btn btn-sm btn-error flex-1 sm:flex-none" data-reservation="{{ $item->id_pemesanan }}">
                                            <i class='bx bx-x-circle'></i>
                                            <span class="hidden xs:inline">Batalkan</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-8">
                        <i class='bx bx-calendar-x text-4xl mb-4'></i>
                        <p class="text-lg">Belum ada riwayat reservasi.</p>
                        <a href="{{ route('reservation') }}" class="btn btn-primary mt-4">
                            <i class='bx bx-plus'></i>
                            Buat Reservasi
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Receipt Modal -->
<dialog id="receipt-modal" class="modal">
    <div class="modal-box max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg" id="receipt-title">Resi Reservasi</h3>
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost">✕</button>
            </form>
        </div>

        <div class="text-center mb-4">
            <h2 class="text-xl font-bold">Seatify Restaurant</h2>
            <p class="text-sm text-base-content/70">Jl. Restoran No. 123, Batam</p>
            <p class="text-sm text-base-content/70">Telp: +62 822 8644 1928</p>
        </div>

        <div class="divider"></div>

        <div class="space-y-2">
            <div class="flex justify-between">
                <p class="text-sm">No. Reservasi</p>
                <p class="font-bold text-sm" id="receipt-number">RSV-1234</p>
            </div>

            <div class="flex justify-between">
                <p class="text-sm">Kode Resi</p>
                <p class="font-bold text-sm" id="receipt-code">RCP-{{ rand(10000, 99999) }}</p>
            </div>

            <div class="flex justify-between">
                <p class="text-sm">Tanggal</p>
                <p class="text-sm" id="receipt-date">2 Mei 2023</p>
            </div>

            <div class="flex justify-between">
                <p class="text-sm">Waktu</p>
                <p class="text-sm" id="receipt-time">19:00</p>
            </div>

            <div class="flex justify-between">
                <p class="text-sm">Status</p>
                <p class="text-sm" id="receipt-status">
                    <span class="badge badge-success badge-sm">Selesai</span>
                </p>
            </div>
        </div>

        <div class="divider"></div>

        <div class="space-y-2">
            <div class="flex justify-between">
                <p class="text-sm">Nomor Meja</p>
                <p class="text-sm" id="receipt-table">Meja 12</p>
            </div>

            <div class="flex justify-between">
                <p class="text-sm">Jumlah Tamu</p>
                <p class="text-sm" id="receipt-guests">4 Orang</p>
            </div>
        </div>

        <div class="divider"></div>

        <div class="space-y-2">
            <div class="flex justify-between font-bold">
                <p>Total</p>
                <p id="receipt-total">Rp265.000</p>
            </div>

            <div class="flex justify-between text-sm text-base-content/70">
                <p>Status Pembayaran</p>
                <p id="receipt-payment-status">
                    <span class="badge badge-success badge-sm">Lunas</span>
                </p>
            </div>
        </div>

        <div class="mt-6 text-center text-xs text-base-content/70">
            <p>Terima kasih telah melakukan reservasi di Seatify Restaurant.</p>
            <p>Silakan tunjukkan resi ini kepada staf kami saat kedatangan.</p>
        </div>

        <div class="modal-action">
            <button class="btn btn-outline btn-sm" onclick="window.print()">
                <i class='bx bx-printer'></i>
                <span>Cetak</span>
            </button>
            <button class="btn btn-primary btn-sm" id="download-receipt">
                <i class='bx bx-download'></i>
                <span>Unduh PDF</span>
            </button>
        </div>
    </div>
</dialog>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const reservationCards = document.querySelectorAll('.reservation-card');
        const statusFilter = document.getElementById('statusFilter');
        const dateFilter = document.getElementById('dateFilter');
        const filterButton = document.getElementById('filterButton');
        const receiptModal = document.getElementById('receipt-modal');

        // Detail buttons handling
        document.querySelectorAll('.show-receipt').forEach(button => {
            button.addEventListener('click', function() {
                const receiptId = this.getAttribute('data-receipt');
                const table = this.getAttribute('data-table');
                const guests = this.getAttribute('data-guests');
                const date = this.getAttribute('data-date');
                const time = this.getAttribute('data-time');
                const total = parseInt(this.getAttribute('data-total')).toLocaleString('id-ID');
                const status = this.getAttribute('data-status');

                // Populate modal with reservation details
                document.getElementById('receipt-number').textContent = 'RSV-' + receiptId;
                document.getElementById('receipt-code').textContent = 'RCP-' + (parseInt(receiptId) + 5000);
                document.getElementById('receipt-date').textContent = date;
                document.getElementById('receipt-time').textContent = time;
                document.getElementById('receipt-table').textContent = table;
                document.getElementById('receipt-guests').textContent = guests + ' Orang';
                document.getElementById('receipt-total').textContent = 'Rp' + total;

                // Set status badges
                if (status === 'completed') {
                    document.getElementById('receipt-status').innerHTML = '<span class="badge badge-success badge-sm">Selesai</span>';
                    document.getElementById('receipt-payment-status').innerHTML = '<span class="badge badge-success badge-sm">Lunas</span>';
                } else if (status === 'scheduled') {
                    document.getElementById('receipt-status').innerHTML = '<span class="badge badge-primary badge-sm">Terjadwal</span>';
                    document.getElementById('receipt-payment-status').innerHTML = '<span class="badge badge-success badge-sm">Lunas</span>';
                } else if (status === 'pending') {
                    document.getElementById('receipt-status').innerHTML = '<span class="badge badge-warning badge-sm">Menunggu Konfirmasi</span>';
                    document.getElementById('receipt-payment-status').innerHTML = '<span class="badge badge-warning badge-sm">Menunggu Konfirmasi</span>';
                } else if (status === 'cancelled') {
                    document.getElementById('receipt-status').innerHTML = '<span class="badge badge-error badge-sm">Dibatalkan</span>';
                    document.getElementById('receipt-payment-status').innerHTML = '<span class="badge badge-error badge-sm">Dibatalkan</span>';
                }

                // Show modal
                receiptModal.showModal();
            });
        });

        // Apply filters
        filterButton.addEventListener('click', function() {
            const statusValue = statusFilter.value;
            const dateValue = dateFilter.value;

            reservationCards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                const cardDate = card.getAttribute('data-date');

                let showByStatus = statusValue === 'all' || cardStatus === statusValue;
                let showByDate = true;

                // Apply date filter logic
                if (dateValue !== 'all') {
                    const reservationDate = new Date(cardDate);
                    const currentDate = new Date();

                    if (dateValue === 'this-month') {
                        showByDate = reservationDate.getMonth() === currentDate.getMonth() &&
                            reservationDate.getFullYear() === currentDate.getFullYear();
                    } else if (dateValue === 'last-month') {
                        const lastMonth = currentDate.getMonth() === 0 ? 11 : currentDate.getMonth() - 1;
                        const lastMonthYear = currentDate.getMonth() === 0 ?
                            currentDate.getFullYear() - 1 : currentDate.getFullYear();

                        showByDate = reservationDate.getMonth() === lastMonth &&
                            reservationDate.getFullYear() === lastMonthYear;
                    } else if (dateValue === 'this-year') {
                        showByDate = reservationDate.getFullYear() === currentDate.getFullYear();
                    }
                }

                // Show or hide the card based on filters
                if (showByStatus && showByDate) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Handle cancel buttons
        document.querySelectorAll('[data-reservation]').forEach(button => {
            button.addEventListener('click', function() {
                const reservationId = this.getAttribute('data-reservation');

                if (confirm(`Apakah Anda yakin ingin membatalkan reservasi #${reservationId}?`)) {
                    // Change the status of the card
                    const card = this.closest('.reservation-card');
                    const statusBadge = card.querySelector('.badge');
                    statusBadge.className = 'badge badge-error whitespace-nowrap shrink-0 px-2 py-3';
                    statusBadge.textContent = 'Dibatalkan';

                    // Change data attribute
                    card.setAttribute('data-status', 'cancelled');

                    // Update price to show cancelled
                    const priceElement = card.querySelector('.font-bold.mb-2.sm\\:mb-0');
                    if (priceElement) {
                        const priceText = priceElement.textContent;
                        if (!priceText.includes('(Dibatalkan)')) {
                            priceElement.innerHTML = `${priceText} <span class="text-error text-sm">(Dibatalkan)</span>`;
                        }
                    }

                    // Remove buttons
                    const buttonsContainer = card.querySelector('.flex.gap-2.flex-grow');
                    if (buttonsContainer) {
                        buttonsContainer.innerHTML = '<span class="text-sm text-error">Reservasi dibatalkan</span>';
                    }

                    alert('Reservasi berhasil dibatalkan');
                }
            });
        });

        // Download receipt PDF button (dummy functionality)
        if (document.getElementById('download-receipt')) {
            document.getElementById('download-receipt').addEventListener('click', function() {
                alert('Fitur unduh PDF sedang dalam pengembangan. Silakan gunakan fitur cetak untuk sementara.');
            });
        }
    });
</script>
@endsection