<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tableBtns = document.querySelectorAll('.table-btn.available');
        const reservationModal = document.getElementById('reservation-modal');
        const closeReservationModal = document.getElementById('closeReservationModal');
        const reservationFormBtn = document.getElementById('reservationFormBtn');
        const openReservationModalBtn = document.getElementById('openReservationModalBtn');
        const selectedTablesInfo = document.getElementById('selectedTablesInfo');
        const tableSummary = document.getElementById('tableSummary');
        const modalTablePrice = document.getElementById('modalTablePrice');
        const modalTotalPrice = document.getElementById('modalTotalPrice');
        const reservationForm = document.getElementById('reservationForm');
        const hiddenTableInputs = document.getElementById('hiddenTableInputs');

        const selectedTables = [];
        let totalPriceValue = 15000; // Biaya layanan

        // Buka modal reservasi
        if (openReservationModalBtn) {
            openReservationModalBtn.addEventListener('click', function () {
                reservationModal.showModal();
            });
        }

        if (reservationFormBtn) {
            reservationFormBtn.addEventListener('click', function () {
                reservationModal.showModal();
            });
        }

        if (closeReservationModal) {
            closeReservationModal.addEventListener('click', function () {
                reservationModal.close();
            });
        }

        // Klik tombol meja
        tableBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const tableId = this.getAttribute('data-table');
                const tablePrice = parseInt(this.getAttribute('data-price'));
                const tableName = this.textContent.trim();

                const tableIndex = selectedTables.findIndex(t => t.id === tableId);

                if (tableIndex > -1) {
                    selectedTables.splice(tableIndex, 1);
                    this.classList.remove('selected');
                } else {
                    selectedTables.push({ id: tableId, name: tableName, price: tablePrice });
                    this.classList.add('selected');
                }

                updateSelectedTablesInfo();
                updatePriceInfo();
                updateTableSummary();
                updateHiddenTableInputs();

                openReservationModalBtn.disabled = selectedTables.length === 0;
            });
        });

        function updateTableSummary() {
            if (selectedTables.length === 0) {
                tableSummary.textContent = 'Belum ada meja yang dipilih';
            } else {
                tableSummary.textContent = selectedTables.map(t => t.name).join(', ');
            }
        }

        function updateSelectedTablesInfo() {
            if (selectedTables.length === 0) {
                selectedTablesInfo.textContent = 'Belum ada meja yang dipilih';
                return;
            }

            selectedTablesInfo.innerHTML = selectedTables.map(table => `
                <div class="flex justify-between items-center mb-1">
                    <span>${table.name}</span>
                    <span>Rp ${table.price.toLocaleString('id-ID')}</span>
                </div>
            `).join('');
        }

        function updateHiddenTableInputs() {
            hiddenTableInputs.innerHTML = '';
            selectedTables.forEach(table => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'no_meja[]';
                input.value = table.id;
                hiddenTableInputs.appendChild(input);
            });
        }

        function updatePriceInfo() {
            const mejaTotal = selectedTables.reduce((sum, t) => sum + t.price, 0);
            totalPriceValue = mejaTotal + 15000;

            modalTablePrice.textContent = `Rp ${mejaTotal.toLocaleString('id-ID')}`;
            modalTotalPrice.textContent = `Rp ${totalPriceValue.toLocaleString('id-ID')}`;
        }

        // Validasi dan submit form
        if (reservationForm) {
            reservationForm.addEventListener('submit', function (e) {
                const customerName = document.getElementById('customerName')?.value;
                const phoneNumber = document.getElementById('phoneNumber')?.value;
                const reservationDate = document.getElementById('reservationDate')?.value;
                const reservationTime = document.getElementById('reservationTime')?.value;
                const guestCount = document.getElementById('guestCount')?.value;

                if (!customerName || !phoneNumber || !reservationDate || !reservationTime || !guestCount || selectedTables.length === 0) {
                    e.preventDefault();
                    alert('Harap lengkapi semua data dan pilih meja terlebih dahulu.');
                    return;
                }

                updateHiddenTableInputs(); // penting agar hidden input no_meja[] di-update sebelum submit

                // Tidak ada e.preventDefault() jika valid, biarkan form submit ke Laravel
            });
        }

        // Validasi tanggal
        const reservationDate = document.getElementById('reservationDate');
        if (reservationDate) {
            reservationDate.min = new Date().toISOString().split('T')[0];
        }

        // Validasi jumlah tamu
        const guestCount = document.getElementById('guestCount');
        if (guestCount) {
            guestCount.addEventListener('input', function () {
                if (parseInt(this.value) < 1) this.value = 1;
                if (parseInt(this.value) > 20) this.value = 20;
            });
        }

        // Hitung karakter catatan
        const notes = document.getElementById('notes');
        const charCount = document.getElementById('charCount');

        if (notes && charCount) {
            notes.addEventListener('input', function () {
                charCount.textContent = this.value.length > 200 ? 200 : this.value.length;
                if (this.value.length > 200) {
                    this.value = this.value.substring(0, 200);
                }
            });
        }
    });
</script>
