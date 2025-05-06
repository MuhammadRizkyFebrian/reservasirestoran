<script>
    document.addEventListener('DOMContentLoaded', function() {
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
        
        const selectedTables = [];
        let totalPriceValue = 15000; // Default service fee
        
        // Handle open reservation modal button
        if (openReservationModalBtn) {
            openReservationModalBtn.addEventListener('click', function() {
                reservationModal.showModal();
            });
        }
        
        // Handle reservation form button
        if (reservationFormBtn) {
            reservationFormBtn.addEventListener('click', function() {
                reservationModal.showModal();
            });
        }
        
        // Handle close reservation modal
        if (closeReservationModal) {
            closeReservationModal.addEventListener('click', function() {
                reservationModal.close();
            });
        }
        
        // Handle table button clicks
        tableBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const tableId = this.getAttribute('data-table');
                const tablePrice = parseInt(this.getAttribute('data-price'));
                const tableName = this.textContent.trim();
                
                const tableIndex = selectedTables.findIndex(t => t.id === tableId);
                
                if (tableIndex > -1) {
                    // Remove table if already selected
                    selectedTables.splice(tableIndex, 1);
                    this.classList.remove('selected');
                } else {
                    // Add table if not selected
                    selectedTables.push({
                        id: tableId,
                        name: tableName,
                        price: tablePrice
                    });
                    this.classList.add('selected');
                }
                
                updateSelectedTablesInfo();
                updatePriceInfo();
                updateTableSummary();
                
                // Enable or disable the reservation button
                if (selectedTables.length > 0) {
                    openReservationModalBtn.disabled = false;
                } else {
                    openReservationModalBtn.disabled = true;
                }
            });
        });
        
        // Update table summary on main page
        function updateTableSummary() {
            if (selectedTables.length === 0) {
                tableSummary.textContent = 'Belum ada meja yang dipilih';
                return;
            }
            
            const tableNames = selectedTables.map(table => table.name).join(', ');
            tableSummary.textContent = tableNames;
        }
        
        // Update selected tables info in modal
        function updateSelectedTablesInfo() {
            if (selectedTables.length === 0) {
                selectedTablesInfo.textContent = 'Belum ada meja yang dipilih';
                return;
            }
            
            let infoHTML = '';
            selectedTables.forEach(table => {
                infoHTML += `<div class="flex justify-between items-center mb-1">
                    <span>${table.name}</span>
                    <span>Rp ${table.price.toLocaleString('id-ID')}</span>
                </div>`;
            });
            
            selectedTablesInfo.innerHTML = infoHTML;
        }
        
        // Update price information
        function updatePriceInfo() {
            const tablePriceValue = selectedTables.reduce((sum, table) => sum + table.price, 0);
            totalPriceValue = tablePriceValue + 15000; // Add service fee
            
            // Update in reservation modal
            modalTablePrice.textContent = `Rp ${tablePriceValue.toLocaleString('id-ID')}`;
            modalTotalPrice.textContent = `Rp ${totalPriceValue.toLocaleString('id-ID')}`;
        }
        
        // Handle form submission
        if (reservationForm) {
            reservationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validasi form sederhana
                const customerName = document.getElementById('customerName')?.value;
                const phoneNumber = document.getElementById('phoneNumber')?.value;
                const reservationDate = document.getElementById('reservationDate')?.value;
                const reservationTime = document.getElementById('reservationTime')?.value;
                const guestCount = document.getElementById('guestCount')?.value;
                
                if (customerName && phoneNumber && reservationDate && reservationTime && guestCount) {
                    // Generate random reservation order code
                    const orderCode = 'RSV' + Math.floor(Math.random() * 90000 + 10000);
                    
                    // Set order code in success modal
                    document.getElementById('successOrderCode').textContent = orderCode;
                    
                    // Close reservation modal and redirect to payment page
                    reservationModal.close();
                    
                    // Redirect to payment page
                    window.location.href = "{{ route('payment') }}";
                }
            });
        }
        
        // Reservation date validation
        const reservationDate = document.getElementById('reservationDate');
        if (reservationDate) {
            reservationDate.min = new Date().toISOString().split('T')[0];
        }
        
        // Guest count validation
        const guestCount = document.getElementById('guestCount');
        if (guestCount) {
            guestCount.addEventListener('input', function() {
                if (parseInt(this.value) < 1) this.value = 1;
                if (parseInt(this.value) > 20) this.value = 20;
            });
        }
        
        // Notes character counter
        const notes = document.getElementById('notes');
        const charCount = document.getElementById('charCount');
        
        if (notes && charCount) {
            notes.addEventListener('input', function() {
                const remaining = this.value.length;
                charCount.textContent = remaining;
                
                // Truncate if somehow exceeds max length
                if (this.value.length > 200) {
                    this.value = this.value.substring(0, 200);
                    charCount.textContent = 200;
                }
            });
        }
    });
</script> 
 