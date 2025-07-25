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
@php
$first = $pemesanan->first();
@endphp

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
            <div class="payment-info-item">
                <span class="payment-info-label">ID Transaksi: #{{ $kode }}</span>
            </div>

            <div class="payment-info-item">
                <span class="payment-info-label">ID Pemesanan: RSV-{{ $first->id_pemesanan ?? '000' }}</span>
            </div>

            <div class="payment-info-item">
                <span class="payment-info-label">Nama Pemesan</span>
                <span class="payment-info-value">{{ $first->nama_pemesan ?? '-' }}</span>
            </div>

            <div class="payment-info-item">
                <span class="payment-info-label">Nomor Telepon</span>
                <span class="payment-info-value">{{ $first->no_handphone ?? '-' }}</span>
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
                            <span class="payment-info-value">Bank BNI</span>
                            <span class="payment-info-value">Bank BRI</span>
                            <span class="payment-info-value">Bank Mandiri</span>
                        </div>

                        <div class="payment-info-item">
                            <span class="payment-info-label">Nomor Rekening</span>
                            <span class="payment-info-value">1234567890</span>
                            <span class="payment-info-value">1234567890</span>
                            <span class="payment-info-value">1234567890</span>
                            <span class="payment-info-value">1234567890</span>
                        </div>

                        <div class="payment-info-item">
                            <span class="payment-info-label">Atas Nama</span>
                            <span class="payment-info-value">PT Seatify Restaurant</span>
                        </div>

                        <div class="payment-info-item">
                            <span class="payment-info-label">Ringkasan Biaya </span>

                            <div class="mt-2 px-4 py-2 bg-base-200 rounded-lg text-sm space-y-2">
                                @php
                                $totalMeja = 0;
                                foreach ($pemesanan as $p) {
                                // Ambil harga dari relasi meja
                                $harga = $p->meja ? $p->meja->harga : 0;
                                $totalMeja += $harga;
                                }
                                $biayaLayanan = 3000;
                                $totalPembayaran = $totalMeja + $biayaLayanan;
                                @endphp

                                <div class="flex justify-between">
                                    <span>Biaya Reservasi Meja</span>
                                    <span>Rp{{ number_format($totalMeja, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Biaya Layanan</span>
                                    <span>Rp{{ number_format($biayaLayanan, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between font-bold border-t border-base-300 pt-2" style="color: red;">
                                    <span>Total</span>
                                    <span>Rp{{ number_format($totalPembayaran, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 mt-4">
                    <div class="payment-info-item">
                        <span class="payment-info-label">Detail Pemesanan</span>

                        @foreach ($pemesanan as $pesan)
                        <div class="flex flex-col mt-2 px-4 py-2 bg-base-200 rounded-lg mb-2">
                            <div class="flex justify-between mb-1">
                                <span class="text-sm">Meja</span>
                                <span class="font-medium">Meja {{ $pesan->no_meja ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm">Jadwal</span>
                                <span class="font-medium">
                                    {{ \Carbon\Carbon::parse($pesan->jadwal ?? '-')->format('d M Y - H:i') }}
                                </span>
                            </div>
                        </div>
                        @endforeach
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

                    <button class="btn btn-primary text-white btn-sm" id="btnConfirmPayment">
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
            @csrf
            <input type="hidden" name="kode_transaksi" value="{{ $kode }}">
            <input type="hidden" name="total_harga" value="{{ $totalPembayaran }}">

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Bank Pengirim</span>
                </label>
                <select name="bank" class="select select-bordered w-full" required>
                    <option value="" disabled selected>Pilih Bank</option>
                    <option value="bca">BCA</option>
                    <option value="bni">BNI</option>
                    <option value="bri">BRI</option>
                    <option value="mandiri">Mandiri</option>
                </select>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Upload Bukti Transfer</span>
                </label>
                <input type="file" name="bukti_pembayaran" class="file-input file-input-bordered w-full" accept="image/*" required>
            </div>

            <div class="alert alert-warning">
                <i class='bx bx-info-circle'></i>
                <span>Pastikan bukti transfer jelas dan menampilkan informasi tanggal, nominal, dan nomor rekening tujuan.</span>
            </div>

            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="confirmPaymentModal.close()">Batal</button>
                <button type="submit" class="btn btn-primary text-white">Kirim Konfirmasi</button>
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

            const formData = new FormData(this);

            fetch('{{ route("payment.confirm") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
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
                    } else {
                        alert(data.error || 'Terjadi kesalahan saat mengirim bukti pembayaran');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'Terjadi kesalahan saat mengirim bukti pembayaran');
                });
        });
    });
</script>
@endsection