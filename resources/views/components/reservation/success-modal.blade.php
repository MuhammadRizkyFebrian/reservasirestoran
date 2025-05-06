<!-- Success Modal Component -->
<dialog id="success-modal" class="modal">
    <div class="modal-box text-center max-w-xs">
        <div class="flex justify-center mb-4">
            <div class="w-20 h-20 rounded-full bg-success flex items-center justify-center text-white">
                <i class='bx bx-check text-5xl'></i>
            </div>
        </div>
        <h3 class="font-bold text-xl mb-3">Reservasi Berhasil!</h3>
        <div class="bg-primary/10 p-3 rounded-xl mb-3 inline-block mx-auto">
            <p class="text-sm mb-1">Kode Pesanan:</p>
            <p class="font-bold text-lg" id="successOrderCode">RSV12345</p>
        </div>
        <p class="mb-2 text-sm">Reservasi Anda telah berhasil dibuat.</p>
        <p class="mb-4 text-xs text-base-content/70">Silakan lanjutkan ke halaman pembayaran.</p>
        <div class="flex flex-col sm:flex-row gap-2 justify-center">
            <div class="modal-action justify-center">
                <a href="{{ route('payment') }}" class="btn btn-primary w-full sm:w-auto">
                    <i class='bx bx-credit-card'></i> Lanjutkan ke Pembayaran
                </a>
            </div>
            <a href="{{ route('reservation-history') }}" class="btn btn-outline btn-sm">
                <i class='bx bx-history mr-1'></i> Riwayat Reservasi
            </a>
        </div>
    </div>
</dialog> 
 