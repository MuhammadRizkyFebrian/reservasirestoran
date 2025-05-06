<!-- Reservation Form Component -->
<div class="card bg-base-200 shadow-xl">
    <div class="card-body">
        <h2 class="card-title text-xl font-bold mb-4">Detail Reservasi</h2>
        
        <form id="reservationForm">
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Tanggal Kunjungan</span>
                </label>
                <input type="date" id="reservationDate" class="input input-bordered" min="{{ date('Y-m-d') }}" required>
            </div>
            
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Waktu Kunjungan</span>
                </label>
                <select id="reservationTime" class="select select-bordered" required>
                    <option value="" disabled selected>Pilih Waktu</option>
                    <option value="11:00">11:00</option>
                    <option value="12:00">12:00</option>
                    <option value="13:00">13:00</option>
                    <option value="14:00">14:00</option>
                    <option value="18:00">18:00</option>
                    <option value="19:00">19:00</option>
                    <option value="20:00">20:00</option>
                    <option value="21:00">21:00</option>
                </select>
            </div>
            
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Jumlah Tamu</span>
                </label>
                <input type="number" id="guestCount" class="input input-bordered" min="1" max="20" placeholder="Jumlah orang" required>
            </div>
            
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Catatan</span>
                </label>
                <textarea id="notes" class="textarea textarea-bordered" placeholder="Masukkan permintaan khusus (opsional)" rows="2" maxlength="200"></textarea>
                <div class="flex justify-between items-center mt-1">
                    <p class="text-xs text-base-content/70">*Durasi reservasi adalah 1 jam</p>
                    <span class="text-xs text-base-content/70"><span id="charCount">0</span>/200 karakter</span>
                </div>
            </div>
            
            <div class="divider"></div>
            
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
                    <span>Rp 15.000</span>
                </div>
                <div class="flex justify-between mt-1 text-lg font-bold">
                    <span>Total</span>
                    <span id="totalPrice">Rp 15.000</span>
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
