@extends('layouts.app', ['noFooter' => true])

@section('title', 'Riwayat Reservasi - ' . config('app.name'))

@section('styles')
<style>
    .reservation-card {
        background-color: var(--fallback-b2, oklch(var(--b2)));
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
        background-color: var(--fallback-b2, oklch(var(--b2)));
        border-radius: 0.75rem;
        padding: 1.25rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.06);
    }

    .profile-sidebar {
        background-color: var(--fallback-b1, oklch(var(--b1)));
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
        border: 3px solid var(--fallback-primary, oklch(var(--p)));
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

    .nav-item:hover,
    .nav-item.active {
        background-color: var(--fallback-primary, oklch(var(--p)));
        color: var(--fallback-primary-content, oklch(var(--pc)));
        color: white;
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
                    <div class="mb-4">
                        @if(auth('pelanggan')->user()->foto_profil)
                        <img src="{{ asset('storage/profile/' . auth('pelanggan')->user()->foto_profil) }}" alt="Profile" class="profile-image">
                        @else
                        <div class="profile-image flex items-center justify-center bg-primary text-primary-content font-medium text-4xl">
                            {{ strtoupper(substr(auth('pelanggan')->user()->username, 0, 2)) }}
                        </div>
                        @endif
                    </div>
                    <h2 class="text-xl font-bold mb-3">{{ auth('pelanggan')->user()->username }}</h2>
                    <div class="flex flex-col items-center space-y-2 text-center">
                        <div class="flex items-center">
                            <i class='bx bx-envelope text-base-content/70 mr-2'></i>
                            <span class="text-sm" id="displayEmail">{{ auth('pelanggan')->user()->email }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class='bx bx-phone text-base-content/70 mr-2'></i>
                            <span class="text-sm" id="displayPhone">{{ auth('pelanggan')->user()->nomor_handphone }}</span>
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
                        <span>Riwayat Reservasi</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-item w-full text-left">
                            <i class='bx bx-log-out'></i>
                            <span>Keluar</span>
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
                            <option value="selesai">Selesai</option>
                            <option value="dikonfirmasi">Dikonfirmasi</option>
                            <option value="menunggu">Menunggu</option>
                            <option value="dibatalkan">Dibatalkan</option>
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
                $status = $item->status;
                $statusLabel = ucfirst($status);
                $badgeClass = match($status) {
                'menunggu' => 'badge-warning',
                'dikonfirmasi' => 'badge-success',
                'selesai' => 'badge-info',
                'dibatalkan' => 'badge-error',
                default => 'badge-warning'
                };

                $meja_array = explode(',', $item->meja_list);
                $meja_text = count($meja_array) > 1
                ? 'Meja ' . implode(', ', $meja_array)
                : 'Meja ' . $meja_array[0];

                $tanggal = \Carbon\Carbon::parse($item->jadwal)->translatedFormat('d M Y');
                $jam = \Carbon\Carbon::parse($item->jadwal)->format('H:i');

                // Hitung total harga
                $biaya_layanan = 3000;
                $total_harga = $item->total_harga ?? 0;
                if ($total_harga == 0) {
                // Jika total_harga belum tersedia, hitung dari jumlah meja
                $total_meja = count($meja_array);
                $harga_meja = \App\Models\Staf_Restoran\Meja::whereIn('no_meja', $meja_array)->sum('harga');
                $total_harga = $harga_meja + $biaya_layanan;
                }
                @endphp

                <div class="reservation-card" data-status="{{ $status }}" data-date="{{ $item->jadwal }}">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-4">
                        <div>
                            <h3 class="font-bold">{{ $item->kode_transaksi }}</h3>
                            <p class="text-sm text-gray-600">{{ $tanggal }}, {{ $jam }}</p>
                        </div>
                        <div class="flex items-center gap-2 mt-2 sm:mt-0">
                            <span class="badge {{ $badgeClass }} whitespace-nowrap shrink-0 px-2 py-3">{{ $statusLabel }}</span>
                        </div>
                    </div>

                    <div class="divider my-2"></div>

                    <div class="mb-4">
                        <div class="flex flex-col gap-2">
                            <div>
                                <p class="text-sm text-base-content/70">Detail Meja</p>
                                <p class="font-medium">{{ $meja_text }}</p>
                                <p class="text-sm">Total {{ count($meja_array) }} meja untuk {{ $item->jumlah_tamu }} orang</p>
                            </div>
                            @if($item->catatan)
                            <div>
                                <p class="text-sm text-base-content/70">Catatan</p>
                                <p class="text-sm">{{ $item->catatan }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <p class="font-bold mb-2 sm:mb-0">Total: Rp{{ number_format($total_harga, 0, ',', '.') }}</p>
                        <div class="flex flex-wrap gap-2 mt-3 justify-between">
                            <div class="flex gap-2 flex-grow">
                                @if($status === 'menunggu')
                                <button class="btn btn-sm btn-info flex-1 sm:flex-none" onclick="showDetailReservation('{{ $item->kode_transaksi }}')">
                                    <i class='bx bx-info-circle'></i>
                                    <span class="hidden xs:inline">Detail</span>
                                </button>
                                <button class="btn btn-sm btn-error flex-1 sm:flex-none" onclick="cancelReservation('{{ $item->kode_transaksi }}')">
                                    <i class='bx bx-x-circle'></i>
                                    <span class="hidden xs:inline">Batalkan</span>
                                </button>
                                @endif

                                @if(in_array($status, ['dikonfirmasi', 'selesai']))
                                <button type="button" class="btn btn-sm btn-info flex-1 sm:flex-none"
                                    data-kode="{{ $item->kode_transaksi }}"
                                    data-tanggal="{{ $tanggal }}"
                                    data-jam="{{ $jam }}"
                                    data-meja="{{ $meja_text }}"
                                    data-tamu="{{ $item->jumlah_tamu }}"
                                    data-total="{{ $total_harga }}"
                                    data-status="{{ $statusLabel }}"
                                    onclick="showReceiptFromData(this)">
                                    <i class='bx bx-receipt'></i>
                                    <span class="hidden xs:inline">Lihat Resi</span>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="divider my-4"></div>
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
                <p class="font-bold text-sm" id="receipt-code"></p>
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
            <button class="btn btn-primary btn-sm" onclick="downloadReceipt()">
                <i class='bx bx-download'></i>
                <span>Unduh PDF</span>
            </button>
        </div>
    </div>
</dialog>

<!-- Detail Reservation Modal -->
<dialog id="detail-reservation-modal" class="modal">
    <div class="modal-box max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg">Detail Reservasi</h3>
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost">✕</button>
            </form>
        </div>

        <div class="space-y-4">
            <div>
                <h4 class="font-semibold mb-2">Informasi Reservasi</h4>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <p class="text-sm text-base-content/70">Kode Reservasi</p>
                        <p class="font-medium text-sm" id="detail-kode"></p>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-sm text-base-content/70">Tanggal & Waktu</p>
                        <p class="text-sm" id="detail-jadwal"></p>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-sm text-base-content/70">Status</p>
                        <p class="text-sm" id="detail-status"></p>
                    </div>
                </div>
            </div>

            <div class="divider my-2"></div>

            <div>
                <h4 class="font-semibold mb-2">Detail Meja</h4>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <p class="text-sm text-base-content/70">Nomor Meja</p>
                        <p class="text-sm" id="detail-meja"></p>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-sm text-base-content/70">Jumlah Tamu</p>
                        <p class="text-sm" id="detail-tamu"></p>
                    </div>
                </div>
            </div>

            <div class="divider my-2"></div>

            <div>
                <h4 class="font-semibold mb-2">Pembayaran</h4>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <p class="text-sm text-base-content/70">Harga Meja</p>
                        <p class="text-sm" id="detail-harga-meja"></p>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-sm text-base-content/70">Biaya Layanan</p>
                        <p class="text-sm" id="detail-biaya-layanan"></p>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-sm text-base-content/70">Total Pembayaran</p>
                        <p class="font-medium" id="detail-total"></p>
                    </div>
                </div>
            </div>

            <div class="divider my-2"></div>

            <div>
                <h4 class="font-semibold mb-2">Bukti Pembayaran</h4>
                <div id="bukti-pembayaran-container" class="space-y-2">
                    <div class="flex justify-between">
                        <p class="text-sm text-base-content/70">Status Pembayaran</p>
                        <p class="text-sm" id="detail-status-pembayaran"></p>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-sm text-base-content/70">Metode Pembayaran</p>
                        <p class="text-sm" id="detail-metode-pembayaran">-</p>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-base-content/70 mb-2">Bukti Transfer</p>
                        <p class="text-sm" id="detail-bukti-text">Belum ada bukti pembayaran</p>
                        <img id="detail-bukti" src="" alt="Bukti Pembayaran" class="mt-2 max-w-full h-auto rounded-lg shadow-lg hidden">
                    </div>
                </div>
            </div>

            <div>
                <h4 class="font-semibold mb-2">Upload Bukti Pembayaran</h4>
                <form id="uploadPaymentForm" class="space-y-4">
                    @csrf
                    <input type="hidden" name="kode_transaksi" id="payment-kode">

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Bank Tujuan</span>
                        </label>
                        <select name="metode_pembayaran" class="select select-bordered select-sm w-full" required>
                            <option value="">Pilih Bank</option>
                            <option value="bca">BCA</option>
                            <option value="bni">BNI</option>
                            <option value="bri">BRI</option>
                            <option value="mandiri">Mandiri</option>
                        </select>
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Bukti Pembayaran</span>
                        </label>
                        <input type="file" name="bukti_pembayaran" accept="image/*" class="file-input file-input-bordered file-input-sm w-full" required />
                        <label class="label">
                            <span class="label-text-alt text-base-content/70">Format: JPG, PNG, JPEG (Max. 2MB)</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-full">
                        <i class='bx bx-upload'></i>
                        Upload Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</dialog>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const reservationCards = document.querySelectorAll('.reservation-card');
        const statusFilter = document.getElementById('statusFilter');
        const dateFilter = document.getElementById('dateFilter');
        const filterButton = document.getElementById('filterButton');
        const receiptModal = document.getElementById('receipt-modal');
        const reservationsList = document.getElementById('reservationsList');

        // Handle cancel buttons
        document.querySelectorAll('[data-reservation]').forEach(button => {
            button.addEventListener('click', function() {
                const kode = this.closest('.reservation-card').querySelector('h3.font-bold').textContent;
                cancelReservation(kode);
            });
        });

        // Apply filters
        filterButton.addEventListener('click', function() {
            const statusValue = statusFilter.value.toLowerCase();
            const dateValue = dateFilter.value;
            let hasVisibleCards = false;

            // Hapus pesan "tidak ada hasil" jika ada
            const existingMessage = document.getElementById('no-results-message');
            if (existingMessage) {
                existingMessage.remove();
            }

            reservationCards.forEach(card => {
                const cardStatus = card.getAttribute('data-status').toLowerCase();
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

                const shouldShow = showByStatus && showByDate;
                card.style.display = shouldShow ? 'block' : 'none';
                if (shouldShow) {
                    hasVisibleCards = true;
                }
            });

            // Tampilkan pesan jika tidak ada hasil yang sesuai filter
            if (!hasVisibleCards && reservationCards.length > 0) {
                const message = document.createElement('div');
                message.id = 'no-results-message';
                message.className = 'text-center text-gray-500 py-8';
                message.innerHTML = `
                    <i class='bx bx-search-alt text-4xl mb-4'></i>
                    <p class="text-lg">Tidak ada reservasi yang sesuai dengan filter.</p>
                `;
                reservationsList.appendChild(message);
            }
        });
    });

    // Global function for showing receipt
    function showReceipt(kode, tanggal, jam, meja, jumlahTamu, totalHarga, status) {
        // Ambil detail resi dari server
        fetch(`/get-receipt-detail/${kode}`)
            .then(response => response.json())
            .then(data => {
                // Update receipt modal content
                document.getElementById('receipt-number').textContent = kode;
                document.getElementById('receipt-code').textContent = data.id_resi || '-';
                document.getElementById('receipt-date').textContent = tanggal;
                document.getElementById('receipt-time').textContent = jam;
                document.getElementById('receipt-table').textContent = meja;
                document.getElementById('receipt-guests').textContent = jumlahTamu + ' Orang';
                document.getElementById('receipt-total').textContent = 'Rp' + totalHarga.toLocaleString('id-ID');

                // Update status badges
                const statusBadgeClass = status.toLowerCase() === 'selesai' ? 'badge-info' : 'badge-success';
                document.getElementById('receipt-status').innerHTML = `<span class="badge ${statusBadgeClass} badge-sm">${status}</span>`;
                document.getElementById('receipt-payment-status').innerHTML = `<span class="badge badge-success badge-sm">Lunas</span>`;

                // Show modal
                document.getElementById('receipt-modal').showModal();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengambil detail resi');
            });
    }

    // Global function for showing receipt from button data
    function showReceiptFromData(button) {
        const data = button.dataset;
        showReceipt(
            data.kode,
            data.tanggal,
            data.jam,
            data.meja,
            parseInt(data.tamu),
            parseFloat(data.total),
            data.status
        );
    }

    function cancelReservation(kode) {
        if (!confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')) {
            return;
        }

        fetch(`/reservation/cancel/${kode}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Perbarui tampilan kartu reservasi
                    const cards = document.querySelectorAll('.reservation-card');
                    const card = Array.from(cards).find(card => {
                        const titleElement = card.querySelector('h3.font-bold');
                        return titleElement && titleElement.textContent.trim() === kode;
                    });

                    if (card) {
                        // Update status badge
                        const statusBadge = card.querySelector('.badge');
                        statusBadge.className = 'badge badge-error whitespace-nowrap shrink-0 px-2 py-3';
                        statusBadge.textContent = 'Dibatalkan';

                        // Update data attribute
                        card.setAttribute('data-status', 'dibatalkan');

                        // Hapus tombol aksi
                        const buttonsContainer = card.querySelector('.flex.gap-2.flex-grow');
                        if (buttonsContainer) {
                            buttonsContainer.innerHTML = '<span class="text-sm text-error">Reservasi dibatalkan</span>';
                        }
                    }
                    alert(data.message);
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                alert(error.message || 'Terjadi kesalahan saat membatalkan reservasi');
            });
    }

    function showDetailReservation(kodeTransaksi) {
        // Ambil data detail pemesanan
        fetch(`/get-reservation-detail/${kodeTransaksi}`)
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    const data = response.data;

                    // Isi data ke dalam modal
                    document.getElementById('detail-kode').textContent = data.kode_transaksi;
                    document.getElementById('detail-jadwal').textContent = `${data.tanggal}, ${data.jam}`;
                    document.getElementById('detail-meja').textContent = data.meja_list;
                    document.getElementById('detail-tamu').textContent = `${data.jumlah_tamu} Orang`;

                    // Format dan tampilkan rincian biaya
                    const hargaMeja = parseInt(data.harga_meja) || 0;
                    const biayaLayanan = parseInt(data.biaya_layanan) || 0;
                    const totalHarga = parseInt(data.total_harga) || 0;

                    document.getElementById('detail-harga-meja').textContent = `Rp${hargaMeja.toLocaleString('id-ID')}`;
                    document.getElementById('detail-biaya-layanan').textContent = `Rp${biayaLayanan.toLocaleString('id-ID')}`;
                    document.getElementById('detail-total').textContent = `Rp${totalHarga.toLocaleString('id-ID')}`;

                    // Set status pemesanan dengan badge
                    const statusBadgeClass =
                        data.status_pemesanan === 'selesai' ? 'badge-info' :
                        data.status_pemesanan === 'dibatalkan' ? 'badge-error' :
                        data.status_pemesanan === 'dikonfirmasi' ? 'badge-success' :
                        'badge-warning';
                    document.getElementById('detail-status').innerHTML =
                        `<span class="badge ${statusBadgeClass} badge-sm">${data.status_pemesanan}</span>`;

                    // Set status pembayaran dengan badge
                    const paymentStatus = data.status_pembayaran.toLowerCase();
                    const paymentBadgeClass =
                        paymentStatus === 'dikonfirmasi' ? 'badge-success' :
                        paymentStatus === 'selesai' ? 'badge-info' :
                        paymentStatus === 'dibatalkan' ? 'badge-error' :
                        'badge-warning';
                    document.getElementById('detail-status-pembayaran').innerHTML =
                        `<span class="badge ${paymentBadgeClass} badge-sm">${data.status_pembayaran}</span>`;

                    // Set metode pembayaran
                    document.getElementById('detail-metode-pembayaran').textContent =
                        data.metode_pembayaran ? data.metode_pembayaran.toUpperCase() : '-';

                    // Tampilkan bukti pembayaran jika ada
                    if (data.bukti_pembayaran) {
                        document.getElementById('detail-bukti-text').style.display = 'none';
                        const buktiUrl = `/storage/bukti_pembayaran/${data.bukti_pembayaran}`;
                        const buktiImg = document.getElementById('detail-bukti');
                        buktiImg.src = buktiUrl;
                        buktiImg.style.display = 'block';
                        buktiImg.onerror = function() {
                            this.style.display = 'none';
                            document.getElementById('detail-bukti-text').style.display = 'block';
                            document.getElementById('detail-bukti-text').textContent = 'Gambar tidak dapat dimuat';
                        };
                    } else {
                        document.getElementById('detail-bukti-text').style.display = 'block';
                        document.getElementById('detail-bukti').style.display = 'none';
                        document.getElementById('detail-bukti-text').textContent = 'Belum ada bukti pembayaran';
                    }

                    // Set kode transaksi untuk form upload
                    document.getElementById('payment-kode').value = data.kode_transaksi;

                    // Show modal
                    document.getElementById('detail-reservation-modal').showModal();
                } else {
                    alert('Gagal mengambil detail reservasi');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengambil detail reservasi');
            });
    }

    // Handle form submission
    document.getElementById('uploadPaymentForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('/upload-payment-proof', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Bukti pembayaran berhasil diupload');
                    location.reload();
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'Terjadi kesalahan saat mengupload bukti pembayaran');
            });
    });

    function downloadReceipt() {
        // Dapatkan data resi
        const kodeTransaksi = document.getElementById('receipt-number').textContent;
        const kodeResi = document.getElementById('receipt-code').textContent;
        const tanggal = document.getElementById('receipt-date').textContent;
        const waktu = document.getElementById('receipt-time').textContent;
        const meja = document.getElementById('receipt-table').textContent;
        const jumlahTamu = document.getElementById('receipt-guests').textContent;
        const total = document.getElementById('receipt-total').textContent;

        // Inisialisasi jsPDF
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4'
        });

        // Set font
        doc.setFont('helvetica');

        // Header
        doc.setFontSize(20);
        doc.text('Seatify Restaurant', 105, 20, {
            align: 'center'
        });

        doc.setFontSize(12);
        doc.text('Jl. Restoran No. 123, Batam', 105, 30, {
            align: 'center'
        });
        doc.text('Telp: +62 822 8644 1928', 105, 35, {
            align: 'center'
        });

        // Garis pemisah
        doc.setLineWidth(0.5);
        doc.line(20, 40, 190, 40);

        // Informasi Reservasi
        doc.setFontSize(14);
        doc.text('Detail Reservasi', 20, 50);

        doc.setFontSize(12);
        const startY = 60;
        const lineHeight = 8;

        // Kolom kiri
        doc.text('No. Reservasi', 20, startY);
        doc.text('Kode Resi', 20, startY + lineHeight);
        doc.text('Tanggal', 20, startY + lineHeight * 2);
        doc.text('Waktu', 20, startY + lineHeight * 3);
        doc.text('Nomor Meja', 20, startY + lineHeight * 4);
        doc.text('Jumlah Tamu', 20, startY + lineHeight * 5);

        // Kolom kanan (nilai)
        doc.text(': ' + kodeTransaksi, 80, startY);
        doc.text(': ' + kodeResi, 80, startY + lineHeight);
        doc.text(': ' + tanggal, 80, startY + lineHeight * 2);
        doc.text(': ' + waktu, 80, startY + lineHeight * 3);
        doc.text(': ' + meja, 80, startY + lineHeight * 4);
        doc.text(': ' + jumlahTamu, 80, startY + lineHeight * 5);

        // Garis pemisah
        doc.line(20, startY + lineHeight * 6, 190, startY + lineHeight * 6);

        // Total pembayaran
        doc.setFontSize(14);
        doc.text('Total Pembayaran:', 20, startY + lineHeight * 7);
        doc.setFont('helvetica', 'bold');
        doc.text(total, 190, startY + lineHeight * 7, {
            align: 'right'
        });

        // Footer
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(10);
        const footerText1 = 'Terima kasih telah melakukan reservasi di Seatify Restaurant.';
        const footerText2 = 'Silakan tunjukkan resi ini kepada staf kami saat kedatangan.';
        doc.text(footerText1, 105, 250, {
            align: 'center'
        });
        doc.text(footerText2, 105, 255, {
            align: 'center'
        });

        // Simpan PDF
        try {
            doc.save(`resi-reservasi-${kodeTransaksi}.pdf`);
        } catch (error) {
            console.error('Error generating PDF:', error);
            alert('Terjadi kesalahan saat mengunduh PDF. Silakan coba lagi.');
        }
    }
</script>
@endsection