<!DOCTYPE html>
<html lang="id" data-theme="lemonade">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - Seatify</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- DaisyUI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    
    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        // Konfigurasi tema Tailwind
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif']
                    },
                }
            }
        };
    </script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        
        .sidebar {
            background-color: var(--fallback-b1,oklch(var(--b1)));
            height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            border-right: 1px solid rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            transition: transform 0.3s ease, width 0.3s ease;
            z-index: 50;
        }
        
        .sidebar-collapsed {
            transform: translateX(-250px);
        }
        
        .sidebar-menu {
            padding: 1rem;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .menu-item.active {
            background-color: var(--fallback-primary,oklch(var(--p)));
            color: var(--fallback-primary-content,oklch(var(--pc)));
            font-weight: 500;
        }
        
        .menu-item:hover:not(.active) {
            background-color: var(--fallback-base-300,oklch(var(--b3)/0.1));
            transform: translateX(5px);
        }
        
        .menu-item i {
            margin-right: 0.75rem;
            font-size: 1.2rem;
            transition: transform 0.2s ease;
        }
        
        .menu-item:hover i {
            transform: scale(1.1);
        }
        
        .menu-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--fallback-primary,oklch(var(--p)));
            transition: width 0.3s ease;
        }
        
        .menu-item:hover::after {
            width: 100%;
        }
        
        .menu-item.active::after {
            width: 0;
        }
        
        .content-wrapper {
            margin-left: 250px;
            padding: 1rem 2rem;
            background-color: var(--fallback-base-100,oklch(var(--b1)));
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        
        .content-wrapper-full {
            margin-left: 0;
        }
        
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 60;
            background-color: var(--fallback-primary,oklch(var(--p)));
            color: var(--fallback-primary-content,oklch(var(--pc)));
            width: 40px;
            height: 40px;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .logout-btn {
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .customer-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 0.75rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }
        
        .customer-table th {
            background-color: var(--fallback-base-200,oklch(var(--b2)));
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
        
        .customer-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--fallback-base-300,oklch(var(--b3)/0.1));
        }
        
        .customer-table tr:last-child td {
            border-bottom: none;
        }
        
        .customer-table tr {
            transition: all 0.3s ease;
        }
        
        .customer-table tr:hover {
            background-color: var(--fallback-base-300,oklch(var(--b3)/0.1));
        }
        
        .customer-table td .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .action-edit-btn, .action-delete-btn {
            transition: all 0.3s ease;
        }
        
        .action-edit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .action-delete-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        /* Tema Switcher */
        .theme-switcher {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 1000;
            background-color: var(--fallback-base-200,oklch(var(--b2)));
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .theme-switcher:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }
        
        /* Search form */
        .search-form {
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .search-form input {
            max-width: 300px;
            transition: all 0.3s ease;
        }
        
        .search-form input:focus {
            box-shadow: 0 0 0 2px var(--fallback-primary,oklch(var(--p)/0.3));
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
        }
        
        .pagination-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .pagination-button {
            transition: all 0.3s ease;
        }
        
        .pagination-button:hover {
            transform: translateY(-2px);
        }
        
        /* Overlay untuk mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        
        .sidebar-overlay.active {
            opacity: 1;
            pointer-events: all;
        }
        
        @media (max-width: 1024px) {
            .mobile-menu-toggle {
                display: flex;
            }
            
            .sidebar {
                transform: translateX(-250px);
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .content-wrapper {
                margin-left: 0;
                padding-top: 4rem;
            }
            
            .header {
                padding-left: 3rem;
            }
            
            .theme-switcher {
                bottom: 20px;
                left: auto;
                right: 20px;
            }
            
            .customer-table {
                display: block;
                overflow-x: auto;
            }
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .header form {
                align-self: flex-end;
            }
            
            .search-form {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .search-form input {
                max-width: 100%;
                width: 100%;
            }
            
            .content-wrapper {
                padding: 4rem 1rem 1rem 1rem;
            }
        }
        
        @media (max-width: 480px) {
            .header h1 {
                font-size: 1.2rem;
            }
            .content-wrapper h2 {
                font-size: 1rem;
            }
            .sidebar {
                width: 80vw;
                min-width: 0;
                max-width: 280px;
                transform: translateX(-80vw);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .content-wrapper {
                margin-left: 0;
                padding: 3.5rem 0.5rem 1rem 0.5rem;
            }
            .mobile-menu-toggle {
                width: 36px;
                height: 36px;
                left: 0.5rem;
                top: 0.5rem;
            }
            .sidebar-menu {
                padding: 0.5rem;
            }
            .menu-item {
                padding: 0.5rem 0.75rem;
                font-size: 0.95rem;
            }
            .customer-table th, .customer-table td {
                padding: 0.5rem;
                font-size: 0.85rem;
            }
        }
        @media (max-width: 320px) {
            .sidebar {
                width: 95vw;
                max-width: 95vw;
            }
            .content-wrapper {
                padding: 3rem 0.2rem 1rem 0.2rem;
            }
        }
    </style>
</head>
<body class="font-poppins">
    <!-- Mobile Menu Toggle -->
    <div class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class='bx bx-menu'></i>
    </div>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="py-4 px-6 border-b border-base-200 flex justify-between items-center">
            <h1 class="text-2xl font-bold flex items-center">
                <i class='bx bx-menu mr-2 text-3xl'></i>
                Menu
            </h1>
            <button class="btn btn-circle btn-sm btn-ghost lg:hidden" id="closeMobileMenu">
                <i class='bx bx-x text-xl'></i>
            </button>
        </div>
        
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item">
                <i class='bx bxs-dashboard'></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('admin.customers') }}" class="menu-item active">
                <i class='bx bxs-user-detail'></i>
                <span>Data Pelanggan</span>
            </a>
            
            <a href="{{ route('admin.tables') }}" class="menu-item">
                <i class='bx bx-table'></i>
                <span>Daftar Meja</span>
            </a>
            
            <a href="{{ route('admin.pemesanan') }}" class="menu-item">
                <i class='bx bx-calendar-edit'></i>
                <span>Pemesanan</span>
            </a>
            
            <a href="{{ route('admin.transactions') }}" class="menu-item">
                <i class='bx bx-history'></i>
                <span>Riwayat Transaksi</span>
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="content-wrapper" id="contentWrapper">
        <div class="header">
            <h1 class="text-3xl font-bold">Data Pelanggan</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline logout-btn">
                    <i class='bx bx-log-out mr-2'></i>
                    Keluar
                </button>
            </form>
        </div>
        
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-6 flex items-center">
                <i class='bx bxs-user-detail mr-2 text-primary'></i>
                Daftar Pelanggan
            </h2>
            
            <!-- Search & Filter Form -->
            <div class="search-form">
                <input type="text" placeholder="Cari pelanggan..." class="input input-bordered" id="searchInput">
                <button class="btn btn-primary">
                    <i class='bx bx-search mr-1'></i>
                    <span>Cari</span>
                </button>
            </div>
            
            <!-- Customer Table -->
            <div class="overflow-x-auto">
                <table class="customer-table bg-base-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>No. Handphone</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Rafles</td>
                            <td>rafles@email.com</td>
                            <td>081234567890</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('1', 'rafles@email.com', 'Rafles', '081234567890')"><i class='bx bx-edit-alt'></i></button>
                                    <button class="btn btn-sm btn-error action-delete-btn"><i class='bx bx-trash'></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Hakim</td>
                            <td>hakim@email.com</td>
                            <td>081234567891</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('2', 'hakim@email.com', 'Hakim', '081234567891')"><i class='bx bx-edit-alt'></i></button>
                                    <button class="btn btn-sm btn-error action-delete-btn"><i class='bx bx-trash'></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Sakila</td>
                            <td>sakila@email.com</td>
                            <td>081234567892</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('3', 'sakila@email.com', 'Sakila', '081234567892')"><i class='bx bx-edit-alt'></i></button>
                                    <button class="btn btn-sm btn-error action-delete-btn"><i class='bx bx-trash'></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Rizki</td>
                            <td>rizki@email.com</td>
                            <td>081234567893</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('4', 'rizki@email.com', 'Rizki', '081234567893')"><i class='bx bx-edit-alt'></i></button>
                                    <button class="btn btn-sm btn-error action-delete-btn"><i class='bx bx-trash'></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Ujang</td>
                            <td>ujang@email.com</td>
                            <td>081234567894</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('5', 'ujang@email.com', 'Ujang', '081234567894')"><i class='bx bx-edit-alt'></i></button>
                                    <button class="btn btn-sm btn-error action-delete-btn"><i class='bx bx-trash'></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                <div class="text-sm text-base-content/70">
                    Menampilkan 1-5 dari 25 pelanggan
                </div>
                <div class="pagination-buttons">
                    <button class="btn btn-sm btn-outline pagination-button" disabled>
                        <i class='bx bx-chevron-left'></i>
                        <span>Sebelumnya</span>
                    </button>
                    <button class="btn btn-sm btn-outline pagination-button">
                        <span>Selanjutnya</span>
                        <i class='bx bx-chevron-right'></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Customer Modal -->
    <dialog id="editCustomerModal" class="modal">
        <div class="modal-box max-w-md">
            <h3 class="font-bold text-lg mb-4">Edit Data Pelanggan</h3>
            <form id="editCustomerForm" class="space-y-4">
                <input type="hidden" id="customerId">
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" id="customerEmail" class="input input-bordered" required>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Username</span>
                    </label>
                    <input type="text" id="customerUsername" class="input input-bordered" required>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">No. Handphone</span>
                    </label>
                    <input type="tel" id="customerPhone" class="input input-bordered" required>
                </div>
                
                <div class="modal-action">
                    <button type="button" class="btn btn-outline" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    
    <!-- Delete Confirmation Modal -->
    <dialog id="deleteConfirmModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Konfirmasi Hapus Pelanggan</h3>
            <p>Apakah Anda yakin ingin menghapus data pelanggan <span id="deleteCustomerName" class="font-bold"></span>?</p>
            <p class="text-error text-sm mt-2">Tindakan ini tidak dapat dibatalkan.</p>
            <div class="modal-action">
                <button class="btn btn-outline" onclick="closeDeleteModal()">Batal</button>
                <button class="btn btn-error" onclick="deleteCustomer()">Hapus</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    
    <!-- Theme Switcher -->
    <div class="theme-switcher dropdown dropdown-right dropdown-end">
        <div tabindex="0" class="w-full h-full flex items-center justify-center cursor-pointer">
            <i class='bx bx-palette text-lg'></i>
        </div>
        <div tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-200 rounded-box w-fit">
            <div class="flex gap-1 p-1">
                <button onclick="document.documentElement.setAttribute('data-theme', 'lemonade')" 
                    class="btn btn-xs btn-circle bg-success" title="Tema Lemonade"></button>
                <button onclick="document.documentElement.setAttribute('data-theme', 'light')" 
                    class="btn btn-xs btn-circle bg-info" title="Tema Light"></button>
                <button onclick="document.documentElement.setAttribute('data-theme', 'dark')" 
                    class="btn btn-xs btn-circle bg-neutral" title="Tema Dark"></button>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const closeMobileMenu = document.getElementById('closeMobileMenu');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const contentWrapper = document.getElementById('contentWrapper');
            const editCustomerModal = document.getElementById('editCustomerModal');
            const deleteConfirmModal = document.getElementById('deleteConfirmModal');
            const editCustomerForm = document.getElementById('editCustomerForm');
            
            // Toggle menu on mobile
            mobileMenuToggle.addEventListener('click', function() {
                sidebar.classList.add('active');
                sidebarOverlay.classList.add('active');
            });
            
            // Close menu function
            function closeSidebar() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            }
            
            // Close menu when clicking close button
            closeMobileMenu.addEventListener('click', closeSidebar);
            
            // Close menu when clicking overlay
            sidebarOverlay.addEventListener('click', closeSidebar);
            
            // Handle responsive design on window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 1024) {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                }
            });
            
            // Check if user previously set a theme preference
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
            }
            
            // Save theme preference when changed
            const themeButtons = document.querySelectorAll('.dropdown-content button');
            themeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const theme = this.getAttribute('title').toLowerCase().split(' ')[1];
                    localStorage.setItem('theme', theme);
                });
            });
            
            // Handle edit form submission
            editCustomerForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const customerId = document.getElementById('customerId').value;
                const email = document.getElementById('customerEmail').value;
                const username = document.getElementById('customerUsername').value;
                const phone = document.getElementById('customerPhone').value;
                
                // Here you would normally make an AJAX request to update the customer data
                console.log(`Updating customer ${customerId} with email: ${email}, username: ${username}, phone: ${phone}`);
                
                // Show success notification (in a real app)
                alert('Data pelanggan berhasil diperbarui!');
                
                // Close the modal
                editCustomerModal.close();
            });
            
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                const searchText = this.value.toLowerCase();
                const rows = document.querySelectorAll('.customer-table tbody tr');
                
                rows.forEach(row => {
                    const email = row.cells[1].textContent.toLowerCase();
                    const username = row.cells[2].textContent.toLowerCase();
                    const phone = row.cells[3].textContent.toLowerCase();
                    
                    if (email.includes(searchText) || username.includes(searchText) || phone.includes(searchText)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
        
        // Function to open edit modal
        function openEditModal(id, email, username, phone) {
            const modal = document.getElementById('editCustomerModal');
            
            // Set values in form
            document.getElementById('customerId').value = id;
            document.getElementById('customerEmail').value = email;
            document.getElementById('customerUsername').value = username;
            document.getElementById('customerPhone').value = phone;
            
            // Open modal
            modal.showModal();
        }
        
        // Function to close edit modal
        function closeEditModal() {
            const modal = document.getElementById('editCustomerModal');
            modal.close();
        }
        
        // Function to open delete confirmation modal
        function confirmDelete(id, username) {
            const modal = document.getElementById('deleteConfirmModal');
            
            // Set customer name in confirmation message
            document.getElementById('deleteCustomerName').textContent = username;
            
            // Store customer ID for deletion
            window.customerToDelete = id;
            
            // Open modal
            modal.showModal();
        }
        
        // Function to close delete modal
        function closeDeleteModal() {
            const modal = document.getElementById('deleteConfirmModal');
            modal.close();
        }
        
        // Function to delete customer
        function deleteCustomer() {
            const id = window.customerToDelete;
            
            // Here you would normally make an AJAX request to delete the customer
            console.log(`Deleting customer with ID: ${id}`);
            
            // Show success notification (in a real app)
            alert('Data pelanggan berhasil dihapus!');
            
            // Close the modal
            closeDeleteModal();
            
            // Remove the row from the table (for demo purposes)
            const rows = document.querySelectorAll('.customer-table tbody tr');
            rows.forEach(row => {
                if (row.cells[0].textContent == id) {
                    row.remove();
                }
            });
        }
    </script>
</body>
</html> 