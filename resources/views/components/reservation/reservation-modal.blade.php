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
                <input type="tel" name="no_handphone" id="phoneNumber" class="input input-bordered" placeholder="Masukkan nomor handphone" required>
            </div>

            <!-- Grid untuk tanggal dan waktu -->
            <div class="grid grid-cols-2 gap-3">
                <div class="form-control">
                    <label class="label py-1">
                        <span class="label-text text-sm">Tanggal</span>
                    </label>
                    <input type="date" name="tanggal" id="reservationDate" class="input input-bordered" min="{{ date('Y-m-d') }}" required>
                </div>
                
                <div class="form-control">
                    <label class="label py-1">
                        <span class="label-text text-sm">Waktu</span>
                    </label>
                    <select name="jam" id="reservationTime" class="select select-bordered" required>
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
            </div>

            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text text-sm">Jumlah Tamu</span>
                </label>
                <input type="number" name="jumlah_tamu" id="guestCount" class="input input-bordered" min="1" max="20" placeholder="Jumlah orang" required>
            </div>

            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text text-sm">Catatan <span class="text-xs opacity-70">(opsional)</span></span>
                </label>
                <textarea name="catatan" id="notes" class="textarea textarea-bordered" placeholder="Masukkan permintaan khusus" rows="2" maxlength="200"></textarea>
                <div class="flex justify-between items-center mt-1">
                    <p class="text-xs opacity-70">*Durasi 1 jam</p>
                    <span class="text-xs opacity-70"><span id="charCount">0</span>/200</span>
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
                    <span>Rp 15.000</span>
                </div>
                <div class="flex justify-between font-bold mt-1">
                    <span>Total</span>
                    <span id="modalTotalPrice">Rp 15.000</span>
                </div>
            </div>

            <div class="form-control">
                <label class="cursor-pointer label justify-start py-1">
                    <input type="checkbox" class="checkbox checkbox-secondary mr-2" required />
                    <span class="label-text text-sm">Saya menyetujui <span class="text-secondary font-medium cursor-pointer" onclick="document.getElementById('terms-modal').showModal()">syarat dan ketentuan</span></span>
                </label>
            </div>

            <div class="form-control">
                <button type="submit" class="btn btn-secondary" id="modalLanjutkanReservasiBtn">Lanjutkan Reservasi</button>
            </div>
        </form>
    </div>
</dialog>
