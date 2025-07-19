<!-- Reservation Modal Form Component -->
@if ($errors->any())
<div class="alert alert-error">
    <ul class="list-disc ml-5 text-sm">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Alert Modal -->
<dialog id="alertModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg" id="alertTitle">Peringatan</h3>
        <p class="py-4" id="alertMessage"></p>
        <div class="modal-action">
            <button class="btn btn-primary" onclick="closeAlertModal()">Mengerti</button>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<dialog id="reservation-modal" class="modal">
    <div class="modal-box max-w-lg">
        <form method="POST" action="{{ route('reservation.store') }}" id="reservationForm" class="space-y-3">
            @csrf

            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" id="closeReservationModal" type="button">✕</button>

            <h3 class="font-bold text-lg mb-3 text-center">Detail Reservasi</h3>

            <!-- Input nama pemesan -->
            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text text-sm">Nama Pemesan</span>
                </label>
                <input type="text" name="nama_pemesan" id="customerName" class="input input-bordered" placeholder="Masukkan nama pemesan" required>
            </div>

            <!-- Input nomor handphone -->
            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text text-sm">Nomor Handphone</span>
                </label>
                <input type="tel" name="no_handphone" id="phoneNumber" class="input input-bordered"
                    pattern="[0-9]*"
                    inputmode="numeric"
                    minlength="10"
                    maxlength="13"
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    placeholder="Masukkan nomor handphone" required>
            </div>

            <!-- Input tersembunyi untuk tanggal dan waktu -->
            <input type="hidden" name="tanggal" id="reservationDate">
            <input type="hidden" name="jam" id="reservationTime">

            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text text-sm">Jumlah Tamu</span>
                    <span class="label-text-alt text-sm" id="maxCapacityInfo"></span>
                </label>
                <input type="tel" name="jumlah_tamu" id="guestCount" class="input input-bordered"
                    pattern="[0-9]*"
                    inputmode="numeric"
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    oninput="limitGuestCount(this)"
                    placeholder="Jumlah orang"
                    required>
            </div>

            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text text-sm">Catatan <span class="text-xs opacity-70">(opsional)</span></span>
                </label>
                <textarea name="catatan" id="notes" class="textarea textarea-bordered" placeholder="Masukkan permintaan khusus" rows="2" maxlength="100"></textarea>
                <div class="flex justify-between items-center mt-1">
                    <p class="text-xs opacity-70">*Durasi 1 jam</p>
                    <span class="text-xs opacity-70"><span id="charCount">0</span>/100</span>
                </div>
            </div>

            <!-- Hidden input jika ingin kirim no_meja -->
            <div id="hiddenTableInputs"></div>

            <!-- Meja dan Biaya -->
            <div class="bg-base-200 p-3 rounded-lg">
                <div class="text-sm font-bold mb-2">Meja Dipilih</div>
                <div id="selectedTablesInfo" class="text-sm mb-2">
                    Belum ada meja yang dipilih
                </div>
                <div class="divider my-2"></div>
                <div class="text-sm font-bold mb-2">Ringkasan Biaya</div>
                <div class="flex justify-between text-sm">
                    <span>Biaya Reservasi Meja</span>
                    <span id="modalTablePrice">Rp 0</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span>Biaya Layanan</span>
                    <span>Rp 3.000</span>
                </div>
                <div class="flex justify-between font-bold mt-1">
                    <span>Total</span>
                    <span id="modalTotalPrice">Rp 3.000</span>
                </div>
            </div>

            <div class="form-control">
                <label class="cursor-pointer label justify-start py-1">
                    <input type="checkbox" class="checkbox checkbox-primary mr-2" required />
                    <span class="label-text text-sm">Saya menyetujui <span class="text-primary font-medium cursor-pointer" onclick="document.getElementById('terms-modal').showModal()">syarat dan ketentuan</span></span>
                </label>
            </div>

            <div class="form-control">
                <button type="submit" class="btn btn-primary text-white" id="modalLanjutkanReservasiBtn">Lanjutkan Reservasi</button>
            </div>
        </form>
    </div>
</dialog>