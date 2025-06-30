<!-- Payment Modal Component -->
<dialog id="payment-modal" class="modal">
    <div class="modal-box max-w-md">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" id="closePaymentModal">✕</button>
        </form>
        <h3 class="font-bold text-lg mb-3 text-center">Pembayaran Reservasi</h3>

        <div class="bg-primary/10 p-2 rounded-lg border border-primary mb-3">
            <div class="grid grid-cols-2 gap-2 mb-2">
                <div class="bg-white/70 rounded-lg p-2 text-center">
                    <p class="text-xs text-base-content/70">Kode Pesanan</p>
                    <p class="font-bold" id="orderCode">RSV12345</p>
                </div>
                <div class="bg-white/70 rounded-lg p-2 text-center">
                    <p class="text-xs text-base-content/70">Kode Transaksi</p>
                    <p class="font-bold" id="transactionCode">TRX987654</p>
                </div>
            </div>
            <div class="text-center text-sm bg-white/70 rounded-lg p-2">
                <p class="font-medium">Transfer ke rekening:</p>
                <p class="font-bold">BCA: 1234567890</p>
                <p class="text-sm">a.n. Restaurant Seatify</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <h4 class="font-medium text-sm mb-1">Rincian Reservasi</h4>
                <div class="bg-base-200 rounded-lg p-2 text-sm space-y-1 h-full">
                    <div class="grid grid-cols-4">
                        <div class="col-span-1 text-xs text-base-content/70">Waktu</div>
                        <div class="col-span-3 font-medium break-words text-xs" id="reservationDateTimeInfo">-</div>
                    </div>
                    <div class="grid grid-cols-4">
                        <div class="col-span-1 text-xs text-base-content/70">Meja</div>
                        <div class="col-span-3 font-medium break-words text-xs" id="reservationTableInfo">-</div>
                    </div>
                    <div class="grid grid-cols-4">
                        <div class="col-span-1 text-xs text-base-content/70">Tamu</div>
                        <div class="col-span-3 font-medium break-words text-xs" id="reservationGuestInfo">-</div>
                    </div>
                    <div class="grid grid-cols-4">
                        <div class="col-span-1 text-xs text-base-content/70">Catatan</div>
                        <div class="col-span-3 font-medium break-words text-xs" id="reservationNotesInfo">-</div>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="font-medium text-sm mb-1">Upload Bukti Pembayaran</h4>
                <div class="bg-base-200 rounded-lg p-2 text-sm space-y-1">
                    <input type="file" accept="image/*" class="file-input file-input-bordered file-input-primary file-input-sm w-full text-xs" id="paymentProof" />
                    <div id="imagePreview" class="hidden mt-1 bg-base-300 p-1 rounded-lg">
                        <img src="" alt="Bukti pembayaran" class="max-h-24 rounded-lg mx-auto object-contain" id="previewImage">
                    </div>
                    <p class="text-xs text-base-content/70">Format: JPG, PNG (max. 2MB)</p>
                </div>
            </div>
        </div>

        <div class="bg-base-200 rounded-lg p-2 text-sm my-3">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <p class="text-xs text-base-content/70">Biaya Reservasi</p>
                    <p class="font-semibold" id="paymentTablePrice">Rp 0</p>
                </div>
                <div>
                    <p class="text-xs text-base-content/70">Biaya Layanan</p>
                    <p class="font-semibold">Rp 15.000</p>
                </div>
            </div>
            <div class="divider my-1"></div>
            <div class="flex justify-between">
                <span class="font-bold">Total</span>
                <span class="font-bold" id="paymentTotalPrice">Rp 15.000</span>
            </div>
        </div>

        <div class="alert alert-info p-2 text-xs mb-3">
            <i class='bx bx-info-circle'></i>
            <span>Reservasi akan dikonfirmasi setelah verifikasi (1-3 jam kerja)</span>
        </div>

        <button id="confirmPaymentBtn" class="btn btn-primary btn-sm w-full">
            <i class='bx bx-check-circle mr-1'></i> Konfirmasi Pembayaran
        </button>
    </div>
</dialog>