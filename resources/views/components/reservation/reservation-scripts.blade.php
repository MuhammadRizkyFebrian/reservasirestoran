<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableBtns = document.querySelectorAll('.table-btn.available');
        const selectedTablesInfo = document.getElementById('selectedTablesInfo');
        const tablePrice = document.getElementById('tablePrice');
        const totalPrice = document.getElementById('totalPrice');
        const reservationForm = document.getElementById('reservationForm');
        const paymentTablePrice = document.getElementById('paymentTablePrice');
        const paymentTotalPrice = document.getElementById('paymentTotalPrice');
        const reservationDateTimeInfo = document.getElementById('reservationDateTimeInfo');
        const reservationTableInfo = document.getElementById('reservationTableInfo');
        const reservationGuestInfo = document.getElementById('reservationGuestInfo');
        const reservationNotesInfo = document.getElementById('reservationNotesInfo');
        const paymentModal = document.getElementById('payment-modal');
        const successModal = document.getElementById('success-modal');
        const confirmPaymentBtn = document.getElementById('confirmPaymentBtn');
        const closePaymentModal = document.getElementById('closePaymentModal');
        const paymentProof = document.getElementById('paymentProof');
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const orderCode = document.getElementById('orderCode');
        const transactionCode = document.getElementById('transactionCode');
        const successOrderCode = document.getElementById('successOrderCode');
        
        const selectedTables = [];
        let totalPriceValue = 15000; // Default service fee
        
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
            });
        });
        
        // Update selected tables info
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
            
            tablePrice.textContent = `Rp ${tablePriceValue.toLocaleString('id-ID')}`;
            totalPrice.textContent = `Rp ${totalPriceValue.toLocaleString('id-ID')}`;
            
            // Also update in payment modal
            paymentTablePrice.textContent = `Rp ${tablePriceValue.toLocaleString('id-ID')}`;
            paymentTotalPrice.textContent = `Rp ${totalPriceValue.toLocaleString('id-ID')}`;
        }
        
        // Handle reservation form submission
        if (reservationForm) {
            reservationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate form
                const date = document.getElementById('reservationDate').value;
                const time = document.getElementById('reservationTime').value;
                const guestCount = document.getElementById('guestCount').value;
                const notes = document.getElementById('notes').value;
                const termsCheckbox = document.getElementById('termsCheckbox').checked;
                
                if (!date || !time || !guestCount || selectedTables.length === 0 || !termsCheckbox) {
                    alert('Harap isi semua field yang diperlukan dan pilih setidaknya satu meja.');
                    return;
                }
                
                // Format date for display
                const dateObj = new Date(date);
                const formattedDate = dateObj.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                // Update reservation info in payment modal
                reservationDateTimeInfo.textContent = `${formattedDate} - ${time}`;
                
                let tableNames = selectedTables.map(table => table.name).join(', ');
                reservationTableInfo.textContent = tableNames;
                
                reservationGuestInfo.textContent = `${guestCount} orang`;
                reservationNotesInfo.textContent = notes || '-';
                
                // Generate random codes
                const randomOrderCode = 'RSV' + Math.floor(10000 + Math.random() * 90000);
                const randomTransactionCode = 'TRX' + Math.floor(100000 + Math.random() * 900000);
                
                orderCode.textContent = randomOrderCode;
                transactionCode.textContent = randomTransactionCode;
                successOrderCode.textContent = randomOrderCode;
                
                // Show payment modal
                paymentModal.showModal();
            });
        }
        
        // Handle payment proof upload
        if (paymentProof) {
            paymentProof.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    const file = e.target.files[0];
                    
                    // Validate file size (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar. Maksimum 2MB.');
                        this.value = '';
                        imagePreview.classList.add('hidden');
                        return;
                    }
                    
                    // Preview image
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                    
                    // Enable confirm button
                    confirmPaymentBtn.disabled = false;
                } else {
                    imagePreview.classList.add('hidden');
                }
            });
        }
        
        // Handle confirm payment button
        if (confirmPaymentBtn) {
            confirmPaymentBtn.addEventListener('click', function() {
                if (!paymentProof.files.length) {
                    alert('Silakan upload bukti pembayaran terlebih dahulu.');
                    return;
                }
                
                // Set reservation code in the success modal
                const orderCode = document.getElementById('orderCode').textContent;
                const successOrderCode = document.getElementById('successOrderCode');
                if (successOrderCode) {
                    successOrderCode.textContent = orderCode;
                }
                
                paymentModal.close();
                successModal.showModal();
            });
        }
        
        // Handle close payment modal
        if (closePaymentModal) {
            closePaymentModal.addEventListener('click', function() {
                paymentModal.close();
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
 