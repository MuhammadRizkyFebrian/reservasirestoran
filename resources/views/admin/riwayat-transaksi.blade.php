<!DOCTYPE html>
<html lang="id" data-theme="lemonade">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Seatify</title>
    
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
        /* Salin style dasar dari halaman admin lain */
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
        
        .transaction-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 0.75rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }
        
        .transaction-table th {
            background-color: var(--fallback-base-200,oklch(var(--b2)));
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
        
        .transaction-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--fallback-base-300,oklch(var(--b3)/0.1));
        }
        
        .transaction-table tr:last-child td {
            border-bottom: none;
        }
        
        .transaction-table tr {
            transition: all 0.3s ease;
        }
        
        .transaction-table tr:hover {
            background-color: var(--fallback-base-300,oklch(var(--b3)/0.1));
        }

        /* Status Transaksi */
        .table-status {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
        }

        .status-confirmed {
            background-color: rgba(0, 200, 0, 0.15); /* Green */
            color: #00C800;
        }
        
        .status-completed {
            background-color: rgba(0, 100, 200, 0.15); /* Blue */
            color: #0064C8;
        }

        /* Aksi (jika ada) */
         .transaction-table td .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
         .action-view-btn {
            transition: all 0.3s ease;
        }
        
        .action-view-btn:hover {
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
            
            .transaction-table {
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
            .transaction-table th, .transaction-table td {
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
            
            <a href="{{ route('admin.customers') }}" class="menu-item">
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
            
            <a href="{{ route('admin.transactions') }}" class="menu-item active"> <!-- Set active -->
                <i class='bx bx-history'></i>
                <span>Riwayat Transaksi</span>
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="content-wrapper" id="contentWrapper">
        <div class="header">
            <h1 class="text-3xl font-bold">Riwayat Transaksi</h1>
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
                <i class='bx bx-history mr-2 text-primary'></i>
                Daftar Transaksi (Selesai & Dikonfirmasi)
            </h2>
            
            <!-- Search Form -->
            <div class="search-form">
                <input type="text" placeholder="Cari transaksi (ID/Pelanggan)..." class="input input-bordered" id="searchInput">
                <button class="btn btn-primary">
                    <i class='bx bx-search mr-1'></i>
                    <span>Cari</span>
                </button>
            </div>
            
            <!-- Transaction Table -->
            <div class="overflow-x-auto">
                <table class="transaction-table bg-base-100">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>ID Pemesanan</th>
                            <th>Username Pemesan</th>
                            <th>Tanggal Transaksi</th>
                            <th>Total Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th> <!-- Kolom Aksi (misal: lihat detail) -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh Data (Hanya Selesai & Dikonfirmasi) -->
                        <tr>
                            <td>#TRX001</td>
                            <td>#RSV001</td>
                            <td>Hakim</td>
                            <td>25 Juni 2024</td>
                            <td>Rp 20.000</td>
                            <td>
                            <span class="table-status status-completed">
                                    <i class='bx bxs-circle mr-1 text-xs'></i>
                                    Selesai
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-info action-view-btn" onclick="viewTransactionDetails('TRX001')">
                                        <i class='bx bx-show-alt'></i>
                                        <span class="hidden sm:inline ml-1">Detail</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>#TRX002</td>
                            <td>#RSV002</td>
                            <td>Sakila</td>
                            <td>27 Juni 2024</td>
                            <td>Rp 40.000</td>
                            <td>
                                <span class="table-status status-completed">
                                    <i class='bx bxs-circle mr-1 text-xs'></i>
                                    Selesai
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-info action-view-btn" onclick="viewTransactionDetails('TRX002')">
                                        <i class='bx bx-show-alt'></i>
                                        <span class="hidden sm:inline ml-1">Detail</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                       
                        <tr>
                            <td>#TRX004</td>
                            <td>#RSV004</td>
                            <td>Rafles</td>
                            <td>27 Juni 2024</td>
                            <td>Rp 40.000</td>
                            <td>
                                <span class="table-status status-confirmed">
                                    <i class='bx bxs-circle mr-1 text-xs'></i>
                                    Dikonfirmasi
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-info action-view-btn" onclick="viewTransactionDetails('TRX004')">
                                        <i class='bx bx-show-alt'></i>
                                        <span class="hidden sm:inline ml-1">Detail</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                <div class="text-sm text-base-content/70">
                    Menampilkan 1-2 dari 2 transaksi
                </div>
                <div class="pagination-buttons">
                    <button class="btn btn-sm btn-outline pagination-button" disabled>
                        <i class='bx bx-chevron-left'></i>
                        <span>Sebelumnya</span>
                    </button>
                    <button class="btn btn-sm btn-outline pagination-button" disabled> <!-- Sesuaikan jika ada halaman selanjutnya -->
                        <span>Selanjutnya</span>
                        <i class='bx bx-chevron-right'></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Transaction Detail Modal (Contoh) -->
    <dialog id="transactionDetailModal" class="modal">
        <div class="modal-box max-w-lg">
            <h3 class="font-bold text-lg mb-4">Detail Transaksi <span id="detailTransactionId" class="font-normal"></span></h3>
            <div class="space-y-2">
                <p><strong>ID Pemesanan:</strong> <span id="detailReservationId"></span></p>
                <p><strong>Username Pemesan:</strong> <span id="detailCustomerName"></span></p>
                <p><strong>Tanggal Transaksi:</strong> <span id="detailTransactionDate"></span></p>
                <p><strong>Total Pembayaran:</strong> <span id="detailTotalPayment"></span></p>
                <p><strong>Status:</strong> <span id="detailStatus"></span></p>
                <!-- Tambahkan detail lain jika perlu -->
            </div>
            <div class="modal-action">
                <button type="button" class="btn btn-outline" onclick="closeDetailModal()">Tutup</button>
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
            const detailModal = document.getElementById('transactionDetailModal');
            
            // Mobile Menu Toggle
            mobileMenuToggle.addEventListener('click', () => {
                sidebar.classList.add('active');
                sidebarOverlay.classList.add('active');
            });
            
            function closeSidebar() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            }
            closeMobileMenu.addEventListener('click', closeSidebar);
            sidebarOverlay.addEventListener('click', closeSidebar);
            
            window.addEventListener('resize', () => {
                if (window.innerWidth > 1024) closeSidebar();
            });
            
            // Theme persistence
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
            }
            document.querySelectorAll('.dropdown-content button[title^="Tema"]').forEach(button => {
                button.addEventListener('click', function() {
                    const theme = this.getAttribute('title').toLowerCase().split(' ')[1];
                    localStorage.setItem('theme', theme);
                });
            });
            
             // Search Functionality (Simple Example)
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                const searchText = this.value.toLowerCase();
                const rows = document.querySelectorAll('.transaction-table tbody tr');
                
                rows.forEach(row => {
                    const transactionId = row.cells[0].textContent.toLowerCase();
                    const customerName = row.cells[2].textContent.toLowerCase();
                    row.style.display = (transactionId.includes(searchText) || customerName.includes(searchText)) ? '' : 'none';
                });
            });
        });

        // Detail Modal Functions
        function viewTransactionDetails(transactionId) {
            const modal = document.getElementById('transactionDetailModal');
            
            // --- GANTI DENGAN DATA ASLI DARI BACKEND --- 
            // Contoh data statis untuk modal detail (tanpa metode pembayaran)
            const transactions = {
                "TRX001": { reservationId: "#RSV001", customerName: "Hakim", date: "25 Juni 2024", total: "Rp 20.000", status: "Selesai" },
                "TRX002": { reservationId: "#RSV002", customerName: "Sakila", date: "1 Juli 2024", total: "Rp 40.000", status: "Selesai" },
                "TRX004": { reservationId: "#RSV004", customerName: "Rafles", date: "19 Mei 2025", total: "Rp 40.000", status: "Dikonfirmasi" }
            };
            const data = transactions[transactionId];
            // --- AKHIR DATA CONTOH --- 
            
            if (data) {
                document.getElementById('detailTransactionId').textContent = transactionId;
                document.getElementById('detailReservationId').textContent = data.reservationId;
                document.getElementById('detailCustomerName').textContent = data.customerName;
                document.getElementById('detailTransactionDate').textContent = data.date;
                document.getElementById('detailTotalPayment').textContent = data.total;
                document.getElementById('detailStatus').textContent = data.status;
                modal.showModal();
            }
        }

        function closeDetailModal() {
            document.getElementById('transactionDetailModal').close();
        }

    </script>
</body>
</html> 