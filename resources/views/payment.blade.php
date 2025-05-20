@extends('layouts.app')

@section('title', 'Pembayaran - ' . config('app.name'))

@section('styles')
.payment-container {
    max-width: 800px;
    margin: 0 auto;
}

.payment-card {
    background-color: var(--fallback-b2,oklch(var(--b2)));
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.payment-header {
    border-bottom: 1px solid var(--fallback-base-300,oklch(var(--bc)/0.1));
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
}

.payment-info-item {
    display: flex;
    flex-direction: column;
    margin-bottom: 1rem;
}

.payment-info-label {
    font-size: 0.875rem;
    color: var(--fallback-base-content/70,oklch(var(--bc)/0.7));
    margin-bottom: 0.25rem;
}

.payment-info-value {
    font-weight: 600;
    font-size: 1rem;
}

.payment-separator {
    height: 1px;
    background-color: var(--fallback-base-300,oklch(var(--bc)/0.1));
    margin: 1.5rem 0;
}

.payment-action {
    margin-top: 2rem;
}

.payment-qr {
    display: flex;
    justify-content: center;
    margin: 1.5rem 0;
}

.payment-qr img {
    max-width: 200px;
    height: auto;
}

@media print {
    .no-print {
        display: none;
    }
    .payment-container {
        width: 100%;
        max-width: 100%;
    }
}
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="payment-container">
        <!-- Payment Card -->
        <div class="payment-card">
            <div class="payment-header flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <div>
                    <h1 class="text-2xl font-bold">Detail Pembayaran</h1>
                    <p class="text-base-content/70 text-sm">Tanggal: {{ date('d M Y') }}</p>
                </div>
                <div class="mt-3 sm:mt-0">
                    <span class="badge badge-warning">Menunggu Konfirmasi</span>
                </div>
            </div>
            
            <!-- Payment Details -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                <div>
                    <div class="payment-info-item">
                        <span class="payment-info-label">ID Transaksi</span>
                        <span class="payment-info-value">#TRX005</span>
                    </div>
                    
                    <div class="payment-info-item">
                        <span class="payment-info-label">ID Pemesanan</span>
                        <span class="payment-info-value">RSV-005</span>
                    </div>
                </div>
                
                <div>
                    <div class="payment-info-item">
                        <span class="payment-info-label">Nama Pemesan</span>
                        <span class="payment-info-value">Rafles</span>
                    </div>
                    
                    <div class="payment-info-item">
                        <span class="payment-info-label">Nomor Telepon</span>
                        <span class="payment-info-value">081234567890</span>
                    </div>
                </div>
            </div>
            
            <!-- Payment Separator -->
            <div class="payment-separator"></div>
            
            <!-- Informasi Pembayaran -->
            <div>
                <h2 class="text-lg font-bold mb-4">Informasi Pembayaran</h2>
                
                <div class="bg-primary/10 p-4 rounded-lg">
                    <p class="mb-3">Silakan transfer pembayaran ke rekening berikut:</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="payment-info-item">
                            <span class="payment-info-label">Bank</span>
                            <span class="payment-info-value">Bank BCA</span>
                        </div>
                        
                        <div class="payment-info-item">
                            <span class="payment-info-label">Nomor Rekening</span>
                            <span class="payment-info-value">1234567890</span>
                        </div>
                        
                        <div class="payment-info-item">
                            <span class="payment-info-label">Atas Nama</span>
                            <span class="payment-info-value">PT Seatify Restaurant</span>
                        </div>
                        
                        <div class="payment-info-item">
                            <span class="payment-info-label">Jumlah</span>
                            <span class="payment-info-value font-bold text-primary">Rp150.000</span>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4 mt-4">
                    <div class="payment-info-item">
                        <span class="payment-info-label">Detail Pemesanan</span>
                        <div class="flex flex-col mt-2 px-4 py-2 bg-base-200 rounded-lg">
                            <div class="flex justify-between mb-1">
                                <span class="text-sm">Meja</span>
                                <span class="font-medium">Meja 3 (2 orang)</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm">Jadwal</span>
                                <span class="font-medium">28 Mei 2025 - 20:00</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info mt-4">
                    <i class='bx bx-info-circle'></i>
                    <span>Pembayaran akan diverifikasi oleh admin setelah Anda mengupload bukti transfer.</span>
                </div>
            </div>
            
            <!-- Payment Actions -->
            <div class="payment-action flex flex-col sm:flex-row gap-3 justify-between no-print">
                <div class="flex gap-2">
                </div>
                
                <div class="flex gap-2">
                    <a href="{{ route('reservation') }}" class="btn btn-ghost btn-sm">
                        <span>Kembali</span>
                    </a>
                    
                    <button class="btn btn-secondary btn-sm" id="btnConfirmPayment">
                        <i class='bx bx-check'></i>
                        <span>Konfirmasi Pembayaran</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Confirmation Modal -->
<dialog id="confirmPaymentModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Konfirmasi Pembayaran</h3>
        
        <form id="paymentConfirmForm" class="space-y-4">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Bank Pengirim</span>
                </label>
                <select class="select select-bordered w-full" required>
                    <option value="" disabled selected>Pilih Bank</option>
                    <option value="bca">BCA</option>
                    <option value="bni">BNI</option>
                    <option value="bri">BRI</option>
                    <option value="mandiri">Mandiri</option>
                </select>
            </div>
            
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nama Pengirim</span>
                </label>
                <input type="text" class="input input-bordered w-full" placeholder="Nama sesuai rekening" required>
            </div>
            
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Upload Bukti Transfer</span>
                </label>
                <input type="file" class="file-input file-input-bordered w-full" accept="image/*" required>
            </div>
            
            <div class="alert alert-warning">
                <i class='bx bx-info-circle'></i>
                <span>Pastikan bukti transfer jelas dan menampilkan informasi tanggal, nominal, dan nomor rekening tujuan.</span>
            </div>
            
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="confirmPaymentModal.close()">Batal</button>
                <button type="submit" class="btn btn-secondary">Kirim Konfirmasi</button>
            </div>
        </form>
    </div>
</dialog>

<!-- Success Notification -->
<div id="successNotification" class="toast toast-end hidden">
    <div class="alert alert-success">
        <i class='bx bx-check-circle'></i>
        <span>Bukti pembayaran berhasil dikirim! Menunggu konfirmasi admin.</span>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmBtn = document.getElementById('btnConfirmPayment');
        const confirmModal = document.getElementById('confirmPaymentModal');
        const confirmForm = document.getElementById('paymentConfirmForm');
        const successNotif = document.getElementById('successNotification');
        
        // Show confirmation modal
        confirmBtn.addEventListener('click', function() {
            confirmModal.showModal();
        });
        
        // Handle form submission
        confirmForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Close modal
            confirmModal.close();
            
            // Show success notification
            successNotif.classList.remove('hidden');
            
            // Hide notification after 3 seconds
            setTimeout(function() {
                successNotif.classList.add('hidden');
                
                // Redirect to reservation history page
                window.location.href = "{{ route('reservation-history') }}";
            }, 3000);
        });
    });
</script>
@endsection