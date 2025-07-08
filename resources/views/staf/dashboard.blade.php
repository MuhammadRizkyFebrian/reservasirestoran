@extends('staf.layouts.staf2')

@section('title', 'Dashboard')

@section('page_title', 'Dashboard Admin')

@section('additional_styles')
.stats-grid {
display: grid;
grid-template-columns: repeat(5, 1fr);
gap: 1.5rem;
}

@media (max-width: 1280px) {
.stats-grid {
grid-template-columns: repeat(3, 1fr);
}
}

@media (max-width: 768px) {
.stats-grid {
grid-template-columns: repeat(2, 1fr);
}
}

@media (max-width: 480px) {
.stats-grid {
grid-template-columns: 1fr;
}
}

.stat-card {
background-color: var(--fallback-base-200, oklch(var(--b2)));
padding: 1.5rem;
border-radius: 0.75rem;
display: flex;
align-items: center;
gap: 1rem;
box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
transform: translateY(-4px);
box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.stat-icon {
background-color: var(--fallback-primary, oklch(var(--p)/0.2));
color: var(--fallback-primary, oklch(var(--p)));
width: 50px;
height: 50px;
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
font-size: 1.5rem;
flex-shrink: 0;
}

.stat-value {
font-size: 1.75rem;
font-weight: 600;
}

.stat-label {
font-size: 0.875rem;
color: var(--fallback-base-content, oklch(var(--bc)/0.7));
}

@media (max-width: 480px) {
.stat-card {
flex-direction: column;
text-align: center;
gap: 0.5rem;
padding: 1rem;
}

.stat-icon {
margin-bottom: 0.5rem;
width: 40px;
height: 40px;
font-size: 1.2rem;
}
}

@media (max-width: 320px) {
.stat-card {
padding: 0.7rem;
}
}
@endsection

@section('content')
<!-- Statistics Section -->
<div class="mb-8">
    <h2 class="text-2xl font-semibold mb-6">Statistik Ringkasan</h2>
    <div class="stats-grid">
        <!-- Stat Card 1: Jumlah Akun Pelanggan -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class='bx bxs-user-account'></i>
            </div>
            <div>
                <div class="stat-value">{{ $totalPelanggan }}</div>
                <div class="stat-label">Jumlah Akun Pelanggan</div>
            </div>
        </div>

        <!-- Stat Card 2: Jumlah Meja -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class='bx bx-table'></i>
            </div>
            <div>
                <div class="stat-value">{{ $totalMeja }}</div>
                <div class="stat-label">Jumlah Meja</div>
            </div>
        </div>

        <!-- Stat Card 3: Jumlah Menu -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class='bx bx-food-menu'></i>
            </div>
            <div>
                <div class="stat-value">{{ $totalMenu }}</div>
                <div class="stat-label">Jumlah Menu</div>
            </div>
        </div>

        <!-- Stat Card 4: Jumlah Reservasi -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class='bx bx-calendar-check'></i>
            </div>
            <div>
                <div class="stat-value">{{ $totalReservasi }}</div>
                <div class="stat-label">Jumlah Reservasi</div>
            </div>
        </div>

        <!-- Stat Card 5: Transaksi Selesai -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class='bx bx-history'></i>
            </div>
            <div>
                <div class="stat-value">{{ $totalTransaksi }}</div>
                <div class="stat-label">Transaksi Selesai</div>
            </div>
        </div>
    </div>
</div>
@endsection