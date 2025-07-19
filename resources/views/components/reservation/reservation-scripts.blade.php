<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi variabel
        const dateInput = document.getElementById('reservationDate');
        const timeInput = document.getElementById('reservationTime');
        const checkAvailabilityBtn = document.getElementById('checkAvailabilityBtn');
        const tableSelectionSection = document.getElementById('tableSelectionSection');
        const tableList = document.getElementById('tableList');
        const reservationModal = document.getElementById('reservation-modal');
        const closeReservationModal = document.getElementById('closeReservationModal');
        const selectedTablesInfo = document.getElementById('selectedTablesInfo');
        const modalTablePrice = document.getElementById('modalTablePrice');
        const modalTotalPrice = document.getElementById('modalTotalPrice');
        const reservationForm = document.getElementById('reservationForm');
        const hiddenTableInputs = document.getElementById('hiddenTableInputs');
        const alertModal = document.getElementById('alertModal');
        const alertTitle = document.getElementById('alertTitle');
        const alertMessage = document.getElementById('alertMessage');

        // Map untuk menyimpan meja yang dipilih
        const selectedTables = new Map();
        let totalPrice = 0;

        // Set batasan tanggal (hari ini sampai 7 hari ke depan)
        if (dateInput) {
            const today = new Date();
            const maxDate = new Date();
            maxDate.setDate(today.getDate() + 7);

            // Format tanggal untuk input date (YYYY-MM-DD)
            const formatDate = (date) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };

            // Set nilai minimal dan maksimal untuk input tanggal
            dateInput.min = formatDate(today);
            dateInput.max = formatDate(maxDate);

            // Set nilai default ke hari ini
            dateInput.value = formatDate(today);

            // Event listener untuk validasi tanggal
            dateInput.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                if (selectedDate < today || selectedDate > maxDate) {
                    showAlert('Peringatan', 'Tanggal harus antara hari ini dan 7 hari ke depan');
                    this.value = formatDate(today);
                }
                updateCheckAvailabilityButton();
            });
        }

        // Fungsi untuk menampilkan alert
        function showAlert(title, message) {
            alertTitle.textContent = title;
            alertMessage.textContent = message;
            alertModal.showModal();
        }

        // Fungsi untuk menutup alert modal
        window.closeAlertModal = function() {
            alertModal.close();
        };

        // Enable/disable check availability button
        function updateCheckAvailabilityButton() {
            const date = dateInput.value;
            const time = timeInput.value;

            if (!date || !time) {
                checkAvailabilityBtn.disabled = true;
                return;
            }

            // Validasi waktu minimal 20 menit
            const jadwalPemesanan = new Date(date + 'T' + time);
            const waktuSekarang = new Date();
            const selisihMenit = (jadwalPemesanan - waktuSekarang) / 1000 / 60;

            checkAvailabilityBtn.disabled = selisihMenit < 20;
        }

        // Event listener untuk perubahan waktu
        timeInput.addEventListener('change', updateCheckAvailabilityButton);
        // Event listener untuk perubahan tanggal
        dateInput.addEventListener('change', updateCheckAvailabilityButton);

        // Update status tombol setiap 1 menit
        setInterval(updateCheckAvailabilityButton, 60000);

        // Check table availability
        checkAvailabilityBtn.addEventListener('click', async function() {
            const date = dateInput.value;
            const time = timeInput.value;

            // Validasi waktu pemesanan minimal 20 menit sebelum jadwal
            const jadwalPemesanan = new Date(date + 'T' + time);
            const waktuSekarang = new Date();
            const selisihMenit = (jadwalPemesanan - waktuSekarang) / 1000 / 60;

            if (selisihMenit < 20) return;

            try {
                const response = await fetch(`/api/check-table-availability?date=${date}&time=${time}`);
                const data = await response.json();

                if (data.success) {
                    // Show table selection section
                    tableSelectionSection.classList.remove('hidden');

                    // Group tables by type
                    const groupedTables = {};
                    data.tables.forEach(table => {
                        if (!groupedTables[table.tipe_meja]) {
                            groupedTables[table.tipe_meja] = [];
                        }
                        groupedTables[table.tipe_meja].push(table);
                    });

                    // Generate table list HTML
                    let html = '';
                    for (const [type, tables] of Object.entries(groupedTables)) {
                        html += `
                        <div class="space-y-2">
                            <h3 class="font-semibold capitalize">Meja ${type}</h3>
                            <div class="grid grid-cols-6 gap-2">
                        `;

                        tables.forEach(table => {
                            const isAvailable = table.status === 'tersedia';
                            html += `
                            <button
                                class="table-btn ${isAvailable ? 'available' : 'reserved'}"
                                data-table="${table.no_meja}"
                                data-price="${table.harga}"
                                data-capacity="${table.kapasitas}"
                                ${!isAvailable ? 'disabled' : ''}>
                                ${table.no_meja}
                                <div class="tooltip">
                                    Kapasitas: ${table.kapasitas} orang<br>
                                    Harga: Rp ${new Intl.NumberFormat('id-ID').format(table.harga)}
                                </div>
                            </button>
                        `;
                        });

                        html += `
                            </div>
                        </div>
                    `;
                    }

                    // Add summary section
                    html += `
                    <div class="mt-8 p-4 bg-base-200 rounded-lg">
                        <h3 class="font-semibold mb-2">Ringkasan</h3>
                        <div id="tableSummary" class="text-sm mb-4">Belum ada meja yang dipilih</div>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-sm font-semibold">Total Pembayaran:</span>
                                <span id="totalPrice" class="text-sm">Rp 0</span>
                            </div>
                            <button id="openReservationModalBtn" class="btn btn-primary text-white " disabled>
                                Lanjutkan Reservasi
                            </button>
                        </div>
                    </div>
                `;

                    tableList.innerHTML = html;

                    // Initialize table selection functionality
                    initializeTableSelection();

                    // Scroll to table selection
                    tableSelectionSection.scrollIntoView({
                        behavior: 'smooth'
                    });
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                showAlert('Error', error.message || 'Terjadi kesalahan saat mengecek ketersediaan meja');
            }
        });

        function initializeTableSelection() {
            const tables = document.querySelectorAll('.table-btn.available');
            const tableSummary = document.getElementById('tableSummary');
            const totalPriceElement = document.getElementById('totalPrice');
            const openReservationModalBtn = document.getElementById('openReservationModalBtn');

            // Reset selected tables
            selectedTables.clear();
            totalPrice = 0;

            tables.forEach(table => {
                table.addEventListener('click', function() {
                    const tableNo = this.dataset.table;
                    const price = parseInt(this.dataset.price);
                    const capacity = parseInt(this.dataset.capacity);

                    if (this.classList.contains('selected')) {
                        this.classList.remove('selected');
                        selectedTables.delete(tableNo);
                        totalPrice -= price;
                    } else {
                        this.classList.add('selected');
                        selectedTables.set(tableNo, {
                            capacity: capacity,
                            price: price
                        });
                        totalPrice += price;
                    }

                    updateTableSummary();
                });
            });

            // Tambahkan event listener untuk tombol Lanjutkan Reservasi
            if (openReservationModalBtn) {
                openReservationModalBtn.addEventListener('click', function() {
                    if (selectedTables.size === 0) {
                        showAlert('Peringatan', 'Silakan pilih meja terlebih dahulu');
                        return;
                    }

                    // Set tanggal dan waktu dari form utama ke form modal
                    const modalDate = document.querySelector('#reservation-modal #reservationDate');
                    const modalTime = document.querySelector('#reservation-modal #reservationTime');

                    if (modalDate) modalDate.value = dateInput.value;
                    if (modalTime) modalTime.value = timeInput.value;

                    // Tambahkan informasi tanggal dan waktu ke ringkasan
                    const formattedDate = new Date(dateInput.value).toLocaleDateString('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    updateSelectedTablesInfo();
                    updatePriceInfo();
                    reservationModal.showModal();
                });
            }
        }

        function updateTableSummary() {
            const tableSummary = document.getElementById('tableSummary');
            const totalPriceElement = document.getElementById('totalPrice');
            const openReservationModalBtn = document.getElementById('openReservationModalBtn');

            if (selectedTables.size > 0) {
                const tableDetails = Array.from(selectedTables).map(([no, data]) =>
                    `Meja ${no} (Kapasitas: ${data.capacity} orang)`
                ).join(', ');
                tableSummary.innerHTML = tableDetails;
                totalPriceElement.textContent = `Rp ${(totalPrice + 3000).toLocaleString('id-ID')}`;
                openReservationModalBtn.disabled = false;
            } else {
                tableSummary.innerHTML = 'Belum ada meja yang dipilih';
                totalPriceElement.textContent = 'Rp 0';
                openReservationModalBtn.disabled = true;
            }

            // Update hidden inputs for form submission
            if (hiddenTableInputs) {
                hiddenTableInputs.innerHTML = Array.from(selectedTables.keys())
                    .map(no => `<input type="hidden" name="no_meja[]" value="${no}">`)
                    .join('');
            }
        }

        function updateSelectedTablesInfo() {
            let tableInfo = '';
            let totalCapacity = 0;

            if (selectedTables.size > 0) {
                tableInfo = 'Meja yang dipilih: ';
                selectedTables.forEach((details, tableNo) => {
                    tableInfo += `No. ${tableNo} (${details.capacity} orang), `;
                    totalCapacity += details.capacity;
                });
                tableInfo = tableInfo.slice(0, -2); // Hapus koma terakhir
            } else {
                tableInfo = 'Belum ada meja yang dipilih';
            }

            selectedTablesInfo.textContent = tableInfo;

            // Update max capacity info
            const maxCapacityInfo = document.getElementById('maxCapacityInfo');
            if (maxCapacityInfo) {
                maxCapacityInfo.textContent = `Maks. ${totalCapacity} orang`;
            }

            // Update max capacity untuk input jumlah tamu
            window.maxGuestCapacity = totalCapacity;
            const guestCount = document.getElementById('guestCount');
            if (guestCount && guestCount.value) {
                limitGuestCount(guestCount);
            }
        }

        // Fungsi untuk membatasi input jumlah tamu
        window.limitGuestCount = function(input) {
            // Hapus karakter non-angka
            input.value = input.value.replace(/[^0-9]/g, '');

            // Hapus angka 0 di awal
            input.value = input.value.replace(/^0+/, '');

            // Konversi ke angka
            let value = parseInt(input.value) || 0;

            // Batasi nilai maksimal
            if (value > window.maxGuestCapacity) {
                input.value = window.maxGuestCapacity;
            }

            // Batasi nilai minimal
            if (value < 1 && input.value !== '') {
                input.value = 1;
            }
        }

        function updatePriceInfo() {
            if (!modalTablePrice || !modalTotalPrice) return;

            const tableTotal = Array.from(selectedTables.values())
                .reduce((sum, table) => sum + table.price, 0);
            const serviceCharge = 3000;
            const total = tableTotal + serviceCharge;

            modalTablePrice.textContent = `Rp ${tableTotal.toLocaleString('id-ID')}`;
            modalTotalPrice.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }

        // Event listener untuk form reservasi
        if (reservationForm) {
            reservationForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validasi waktu pemesanan minimal 20 menit sebelum jadwal
                const selectedDate = dateInput.value;
                const selectedTime = timeInput.value;
                const jadwalPemesanan = new Date(selectedDate + 'T' + selectedTime);
                const waktuSekarang = new Date();
                const selisihMenit = (jadwalPemesanan - waktuSekarang) / 1000 / 60;

                if (selisihMenit < 20) return;

                // Validasi meja yang dipilih
                if (selectedTables.size === 0) {
                    showAlert('Peringatan', 'Silakan pilih minimal satu meja.');
                    return;
                }

                // Validasi jumlah tamu
                const guestCount = document.getElementById('guestCount');
                const jumlahTamu = parseInt(guestCount.value) || 0;
                let totalCapacity = 0;
                selectedTables.forEach((details) => {
                    totalCapacity += details.capacity;
                });

                if (jumlahTamu < 1 || jumlahTamu > totalCapacity) {
                    showAlert('Peringatan', `Jumlah tamu harus antara 1 dan ${totalCapacity} orang`);
                    return;
                }

                // Lanjutkan dengan pengiriman form
                const formData = new FormData();
                formData.append('nama_pemesan', document.getElementById('customerName').value);
                formData.append('no_handphone', document.getElementById('phoneNumber').value);
                formData.append('tanggal', selectedDate);
                formData.append('jam', selectedTime);
                formData.append('jumlah_tamu', document.getElementById('guestCount').value);
                formData.append('_token', '{{ csrf_token() }}');

                // Tambahkan meja yang dipilih
                selectedTables.forEach((data, tableNo) => {
                    formData.append('no_meja[]', tableNo);
                });

                // Kirim form
                fetch('{{ route("reservation.store") }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.redirect;
                        } else {
                            showAlert('Error', data.message);
                        }
                    })
                    .catch(error => {
                        showAlert('Error', 'Terjadi kesalahan saat memproses reservasi.');
                        console.error('Error:', error);
                    });
            });
        }

        // Event listener untuk textarea catatan
        const notesTextarea = document.getElementById('notes');
        const charCount = document.getElementById('charCount');

        if (notesTextarea && charCount) {
            notesTextarea.addEventListener('input', function() {
                const count = this.value.length;
                charCount.textContent = count;
            });
        }

        // Handle modal close
        if (closeReservationModal) {
            closeReservationModal.addEventListener('click', function() {
                reservationModal.close();
            });
        }
    });
</script>