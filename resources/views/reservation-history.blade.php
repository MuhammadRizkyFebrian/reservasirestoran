@extends('layouts.app', ['noFooter' => true])

@section('title', 'Riwayat Reservasi - ' . config('app.name'))

@section('styles')
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
@endsection

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Sidebar Profile -->
        <div class="md:col-span-1">
            <div class="profile-sidebar">
                <a href="{{ route('home') }}" class="flex items-center text-primary mb-6">
                    <i class='bx bx-chevron-left text-xl'></i>
                    <span>Kembali</span>
                </a>
                
                <div class="flex flex-col items-center mb-6">
                    <div class="relative mb-4">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Profile" class="profile-image">
                        <div class="edit-button">
                            <i class='bx bx-plus'></i>
                        </div>
                    </div>
                    <h2 class="text-xl font-bold mb-3">JohnDoe123</h2>
                    <div class="flex flex-col items-center space-y-2 text-center">
                        <div class="flex items-center">
                            <i class='bx bx-envelope text-base-content/70 mr-2'></i>
                            <span class="text-sm">johndoe@example.com</span>
                        </div>
                        <div class="flex items-center">
                            <i class='bx bx-phone text-base-content/70 mr-2'></i>
                            <span class="text-sm">+62 812 3456 7890</span>
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
                        <button class="btn btn-primary" id="filterButton">
                            <i class='bx bx-filter-alt mr-2'></i> Filter
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Reservations List -->
            <div id="reservationsList">
                <!-- Reservation 1 -->
                <div class="reservation-card" data-status="completed" data-date="2023-05-02">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-2">
                        <div class="mb-2 sm:mb-0 max-w-full overflow-hidden">
                            <h3 class="font-bold text-lg truncate">Reservasi #1234</h3>
                            <p class="text-sm text-base-content/70">2 Mei 2023 - 19:00</p>
                        </div>
                        <span class="badge badge-success whitespace-nowrap shrink-0">Selesai</span>
                    </div>
                    
                    <div class="divider my-2"></div>
                    
                    <div class="mb-2">
                        <p class="text-sm text-base-content/70">Meja</p>
                        <p class="font-medium break-words">Meja 12 (4 orang)</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <p class="font-bold mb-2 sm:mb-0 break-words">Total: Rp265.000</p>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <a href="{{ route('reservation-receipt') }}" class="btn btn-sm btn-outline flex-1 sm:flex-none">
                                <i class='bx bx-food-menu mr-1'></i> Lihat Detail
                            </a>
                            <button class="btn btn-sm btn-primary flex-1 sm:flex-none" data-reservation="1234">
                                <i class='bx bx-calendar-check mr-1'></i> Pesan Lagi
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Reservation 2 -->
                <div class="reservation-card" data-status="scheduled" data-date="2023-05-15">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-2">
                        <div class="mb-2 sm:mb-0 max-w-full overflow-hidden">
                            <h3 class="font-bold text-lg truncate">Reservasi #1156</h3>
                            <p class="text-sm text-base-content/70">15 Mei 2023 - 20:00</p>
                        </div>
                        <span class="badge badge-primary whitespace-nowrap shrink-0">Terjadwal</span>
                    </div>
                    
                    <div class="divider my-2"></div>
                    
                    <div class="mb-2">
                        <p class="text-sm text-base-content/70">Meja</p>
                        <p class="font-medium break-words">Meja 5 (2 orang)</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <p class="font-bold mb-2 sm:mb-0 break-words">Total: Rp80.000</p>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <a href="{{ route('reservation-receipt') }}" class="btn btn-sm btn-outline flex-1 sm:flex-none">
                                <i class='bx bx-food-menu mr-1'></i> Lihat Detail
                            </a>
                            <button class="btn btn-sm btn-error flex-1 sm:flex-none" data-reservation="1156">
                                <i class='bx bx-x-circle mr-1'></i> Batalkan
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Reservation 3 -->
                <div class="reservation-card" data-status="cancelled" data-date="2023-04-10">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-2">
                        <div class="mb-2 sm:mb-0 max-w-full overflow-hidden">
                            <h3 class="font-bold text-lg truncate">Reservasi #1089</h3>
                            <p class="text-sm text-base-content/70">10 April 2023 - 13:00</p>
                        </div>
                        <span class="badge badge-error whitespace-nowrap shrink-0">Dibatalkan</span>
                    </div>
                    
                    <div class="divider my-2"></div>
                    
                    <div class="mb-2">
                        <p class="text-sm text-base-content/70">Meja</p>
                        <p class="font-medium break-words">Meja 8 (3 orang)</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <p class="font-bold mb-2 sm:mb-0 break-words">Total: Rp80.000 <span class="text-error text-sm">(Dibatalkan)</span></p>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <a href="{{ route('reservation-receipt') }}" class="btn btn-sm btn-outline flex-1 sm:flex-none">
                                <i class='bx bx-food-menu mr-1'></i> Lihat Detail
                            </a>
                            <button class="btn btn-sm btn-primary flex-1 sm:flex-none" data-reservation="1089">
                                <i class='bx bx-calendar-check mr-1'></i> Pesan Lagi
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Reservation 4 - Menggunakan data VIP -->
                <div class="reservation-card" data-status="completed" data-date="2023-06-10">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-2">
                        <div class="mb-2 sm:mb-0 max-w-full overflow-hidden">
                            <h3 class="font-bold text-lg truncate">Reservasi #1392</h3>
                            <p class="text-sm text-base-content/70">10 Juni 2023 - 21:00</p>
                        </div>
                        <span class="badge badge-success whitespace-nowrap shrink-0">Selesai</span>
                    </div>
                    
                    <div class="divider my-2"></div>
                    
                    <div class="mb-2">
                        <p class="text-sm text-base-content/70">Meja</p>
                        <p class="font-medium break-words">VIP-1 (6 orang)</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <p class="font-bold mb-2 sm:mb-0 break-words">Total: Rp135.000</p>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <a href="{{ route('reservation-receipt') }}" class="btn btn-sm btn-outline flex-1 sm:flex-none">
                                <i class='bx bx-food-menu mr-1'></i> Lihat Detail
                            </a>
                            <button class="btn btn-sm btn-primary flex-1 sm:flex-none" data-reservation="1392">
                                <i class='bx bx-calendar-check mr-1'></i> Pesan Lagi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const reservationCards = document.querySelectorAll('.reservation-card');
        const statusFilter = document.getElementById('statusFilter');
        const dateFilter = document.getElementById('dateFilter');
        const filterButton = document.getElementById('filterButton');
        
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
        
        // Detail and Booking buttons
        document.querySelectorAll('[data-reservation]').forEach(button => {
            button.addEventListener('click', function() {
                const reservationId = this.getAttribute('data-reservation');
                
                if (this.textContent.includes('Lihat Detail')) {
                    alert(`Detail reservasi #${reservationId} akan ditampilkan`);
                } else if (this.textContent.includes('Pesan Lagi')) {
                    alert(`Anda akan membuat reservasi baru berdasarkan reservasi #${reservationId}`);
                } else if (this.textContent.includes('Batalkan')) {
                    if (confirm(`Apakah Anda yakin ingin membatalkan reservasi #${reservationId}?`)) {
                        alert('Reservasi berhasil dibatalkan');
                        
                        // Change the status of the card
                        const card = this.closest('.reservation-card');
                        const statusBadge = card.querySelector('.badge');
                        statusBadge.className = 'badge badge-error';
                        statusBadge.textContent = 'Dibatalkan';
                        
                        // Change data attribute
                        card.setAttribute('data-status', 'cancelled');
                        
                        // Update buttons
                        const buttonsContainer = card.querySelector('.flex.gap-2');
                        buttonsContainer.innerHTML = `
                            <a href="/reservation-receipt" class="btn btn-sm btn-outline flex-1 sm:flex-none">
                                <i class='bx bx-food-menu mr-1'></i> Lihat Detail
                            </a>
                            <button class="btn btn-sm btn-primary flex-1 sm:flex-none" data-reservation="${reservationId}">
                                <i class='bx bx-calendar-check mr-1'></i> Pesan Lagi
                            </button>
                        `;
                    }
                }
            });
        });
    });
</script>
@endsection 
 