<!-- Reservation Form Component -->
<div class="card bg-base-200 shadow-xl">
    <div class="card-body">
        <h2 class="card-title text-xl font-bold mb-4">Detail Reservasi</h2>

        <form id="reservationForm">
            <!-- Hidden inputs for date and time -->
            <input type="hidden" id="selectedDate" name="tanggal">
            <input type="hidden" id="selectedTime" name="jam">

            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Nama Pemesan</span>
                </label>
                <input type="text" id="customerName" name="nama_pemesan" class="input input-bordered" required>
            </div>

            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Nomor Handphone</span>
                </label>
                <input type="tel" id="phoneNumber" name="no_handphone" class="input input-bordered" required>
            </div>

            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Jumlah Tamu</span>
                </label>
                <input type="number" id="guestCount" name="jumlah_tamu" class="input input-bordered" min="1" max="20" placeholder="Jumlah orang" required>
            </div>

            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Catatan</span>
                </label>
                <textarea id="notes" name="catatan" class="textarea textarea-bordered" placeholder="Masukkan permintaan khusus (opsional)" rows="2" maxlength="200"></textarea>
                <div class="flex justify-between items-center mt-1">
                    <p class="text-xs text-base-content/70">*Durasi reservasi adalah 1 jam</p>
                    <span class="text-xs text-base-content/70"><span id="charCount">0</span>/200 karakter</span>
                </div>
            </div>

            <div class="divider"></div>

            <div class="mb-4">
                <h3 class="font-bold text-lg">Jadwal Kunjungan</h3>
                <div id="scheduleInfo" class="mt-2 text-gray-600"></div>
            </div>

            <div class="mb-4">
                <h3 class="font-bold text-lg">Meja Dipilih</h3>
                <div id="selectedTablesInfo" class="mt-2 text-gray-600">
                    Belum ada meja yang dipilih
                </div>
            </div>

            <div class="divider"></div>

            <div class="mb-4">
                <h3 class="font-bold text-lg">Ringkasan Biaya</h3>
                <div class="flex justify-between mt-2">
                    <span>Biaya Reservasi Meja</span>
                    <span id="tablePrice">Rp 0</span>
                </div>
                <div class="flex justify-between mt-1">
                    <span>Biaya Layanan</span>
                    <span>Rp 3.000</span>
                </div>
                <div class="flex justify-between mt-1 text-lg font-bold">
                    <span>Total</span>
                    <span id="totalPrice">Rp 3.000</span>
                </div>
            </div>

            <div class="form-control mt-4">
                <label class="cursor-pointer label justify-start">
                    <input type="checkbox" class="checkbox checkbox-primary mr-2" id="termsCheckbox" required />
                    <span class="label-text">Saya menyetujui <span class="text-primary font-medium cursor-pointer" onclick="document.getElementById('terms-modal').showModal()">syarat dan ketentuan</span> yang berlaku</span>
                </label>
            </div>

            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary" id="lanjutkanReservasiBtn">Lanjutkan Reservasi</button>
            </div>
        </form>
    </div>
</div>