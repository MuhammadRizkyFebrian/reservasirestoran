<!DOCTYPE html>
<html lang="id" data-theme="lemonade">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Meja - Seatify</title>
    
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
        
        .table-data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 0.75rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }
        
        .table-data-table th {
            background-color: var(--fallback-base-200,oklch(var(--b2)));
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
        
        .table-data-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--fallback-base-300,oklch(var(--b3)/0.1));
        }
        
        .table-data-table tr:last-child td {
            border-bottom: none;
        }
        
        .table-data-table tr {
            transition: all 0.3s ease;
        }
        
        .table-data-table tr:hover {
            background-color: var(--fallback-base-300,oklch(var(--b3)/0.1));
        }
        
        .table-data-table td .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .table-status {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
        }
        
        .status-available {
            background-color: rgba(var(--success-rgb, 0, 200, 0), 0.15);
            color: var(--fallback-success,oklch(var(--su)));
        }
        
        .status-booked {
            background-color: rgba(var(--error-rgb, 200, 0, 0), 0.15);
            color: var(--fallback-error,oklch(var(--er)));
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
        
        /* Button tambah meja */
        .add-table-btn {
            transition: all 0.3s ease;
        }
        
        .add-table-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            
            .table-data-table {
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
            .table-data-table th, .table-data-table td {
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
            
            <a href="{{ route('admin.tables') }}" class="menu-item active">
                <i class='bx bx-table'></i>
                <span>Daftar Meja</span>
            </a>

            <a href="{{ route('admin.menu') }}" class="menu-item">
                <i class='bx  bx-food-menu'></i> 
                <span>Daftar Menu</span>
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
            <h1 class="text-3xl font-bold">Data Meja</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline logout-btn">
                    <i class='bx bx-log-out mr-2'></i>
                    Keluar
                </button>
            </form>
        </div>
        
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold flex items-center">
                    <i class='bx bx-table mr-2 text-primary'></i>
                    Daftar Meja
                </h2>
                <button class="btn btn-primary add-table-btn" onclick="openAddModal()">
                    <i class='bx bx-plus mr-1'></i>
                    <span>Tambah Meja</span>
                </button>
            </div>
            
            <!-- Search & Filter Form -->
            <div class="search-form">
                <input type="text" placeholder="Cari meja..." class="input input-bordered" id="searchInput">
                <div class="flex gap-2">
                    <select class="select select-bordered" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="available">Tersedia</option>
                        <option value="booked">Dipesan</option>
                    </select>
                    <button class="btn btn-primary">
                        <i class='bx bx-search mr-1'></i>
                        <span>Cari</span>
                    </button>
                </div>
            </div>
            
            <!-- Table Data Table -->
            <div class="overflow-x-auto">
                <table class="table-data-table bg-base-100">
                    <thead>
                        <tr>
                            <th>Nomor Meja</th>
                            <th>Tipe Meja</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>T1</td>
                            <td>Persegi</td>
                            <td>Rp 25.000</td>
                            <td>
                                <span class="table-status status-available">
                                    <i class='bx bxs-circle mr-1 text-xs'></i>
                                    Tersedia
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('T1', 'Persegi', '25000', 'available')">
                                        <i class='bx bx-edit-alt'></i>
                                        <span class="hidden sm:inline ml-1">Edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-error action-delete-btn" onclick="confirmDelete('T1')">
                                        <i class='bx bx-trash'></i>
                                        <span class="hidden sm:inline ml-1">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>T2</td>
                            <td>Persegi</td>
                            <td>Rp 25.000</td>
                            <td>
                                <span class="table-status status-available">
                                    <i class='bx bxs-circle mr-1 text-xs'></i>
                                    Tersedia
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('T2', 'Persegi', '25000', 'available')">
                                        <i class='bx bx-edit-alt'></i>
                                        <span class="hidden sm:inline ml-1">Edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-error action-delete-btn" onclick="confirmDelete('T2')">
                                        <i class='bx bx-trash'></i>
                                        <span class="hidden sm:inline ml-1">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>T3</td>
                            <td>Persegi</td>
                            <td>Rp 25.000</td>
                            <td>
                                <span class="table-status status-available">
                                    <i class='bx bxs-circle mr-1 text-xs'></i>
                                    Tersedia
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('T3', 'Persegi', '25000', 'available')">
                                        <i class='bx bx-edit-alt'></i>
                                        <span class="hidden sm:inline ml-1">Edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-error action-delete-btn" onclick="confirmDelete('T3')">
                                        <i class='bx bx-trash'></i>
                                        <span class="hidden sm:inline ml-1">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>T4</td>
                            <td>Persegi</td>
                            <td>Rp 25.000</td>
                            <td>
                                <span class="table-status status-booked">
                                    <i class='bx bxs-circle mr-1 text-xs'></i>
                                    Dipesan
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('T4', 'Persegi', '25000', 'booked')">
                                        <i class='bx bx-edit-alt'></i>
                                        <span class="hidden sm:inline ml-1">Edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-error action-delete-btn" onclick="confirmDelete('T4')">
                                        <i class='bx bx-trash'></i>
                                        <span class="hidden sm:inline ml-1">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>T5</td>
                            <td>Bundar</td>
                            <td>Rp 40.000</td>
                            <td>
                                <span class="table-status status-available">
                                    <i class='bx bxs-circle mr-1 text-xs'></i>
                                    Tersedia
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('T5', 'Bundar', '40000', 'available')">
                                        <i class='bx bx-edit-alt'></i>
                                        <span class="hidden sm:inline ml-1">Edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-error action-delete-btn" onclick="confirmDelete('T5')">
                                        <i class='bx bx-trash'></i>
                                        <span class="hidden sm:inline ml-1">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>T6</td>
                            <td>Bundar</td>
                            <td>Rp 40.000</td>
                            <td>
                                <span class="table-status status-available">
                                    <i class='bx bxs-circle mr-1 text-xs'></i>
                                    Tersedia
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('T6', 'Bundar', '40000', 'available')">
                                        <i class='bx bx-edit-alt'></i>
                                        <span class="hidden sm:inline ml-1">Edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-error action-delete-btn" onclick="confirmDelete('T6')">
                                        <i class='bx bx-trash'></i>
                                        <span class="hidden sm:inline ml-1">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>T7</td>
                            <td>Bundar</td>
                            <td>Rp 40.000</td>
                            <td>
                                <span class="table-status status-booked">
                                    <i class='bx bxs-circle mr-1 text-xs'></i>
                                    Dipesan
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('T7', 'Bundar', '40000', 'booked')">
                                        <i class='bx bx-edit-alt'></i>
                                        <span class="hidden sm:inline ml-1">Edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-error action-delete-btn" onclick="confirmDelete('T7')">
                                        <i class='bx bx-trash'></i>
                                        <span class="hidden sm:inline ml-1">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>T8</td>
                            <td>Persegi Panjang</td>
                            <td>Rp 60.000</td>
                            <td>
                                <span class="table-status status-available">
                                    <i class='bx bxs-circle mr-1 text-xs'></i>
                                    Tersedia
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('T8', 'Persegi Panjang', '60000', 'available')">
                                        <i class='bx bx-edit-alt'></i>
                                        <span class="hidden sm:inline ml-1">Edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-error action-delete-btn" onclick="confirmDelete('T8')">
                                        <i class='bx bx-trash'></i>
                                        <span class="hidden sm:inline ml-1">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>T9</td>
                            <td>Persegi Panjang</td>
                            <td>Rp 60.000</td>
                            <td>
                                <span class="table-status status-available">
                                    <i class='bx bxs-circle mr-1 text-xs'></i>
                                    Tersedia
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('T9', 'Persegi Panjang', '60000', 'available')">
                                        <i class='bx bx-edit-alt'></i>
                                        <span class="hidden sm:inline ml-1">Edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-error action-delete-btn" onclick="confirmDelete('T9')">
                                        <i class='bx bx-trash'></i>
                                        <span class="hidden sm:inline ml-1">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>T10</td>
                            <td>Persegi Panjang</td>
                            <td>Rp 60.000</td>
                            <td>
                                <span class="table-status status-booked">
                                    <i class='bx bxs-circle mr-1 text-xs'></i>
                                    Dipesan
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('T10', 'Persegi Panjang', '60000', 'booked')">
                                        <i class='bx bx-edit-alt'></i>
                                        <span class="hidden sm:inline ml-1">Edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-error action-delete-btn" onclick="confirmDelete('T10')">
                                        <i class='bx bx-trash'></i>
                                        <span class="hidden sm:inline ml-1">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>T11</td>
                            <td>VIP</td>
                            <td>Rp 90.000</td>
                            <td>
                                <span class="table-status status-available">
                                    <i class='bx bxs-circle mr-1 text-xs'></i>
                                    Tersedia
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('T11', 'VIP', '90000', 'available')">
                                        <i class='bx bx-edit-alt'></i>
                                        <span class="hidden sm:inline ml-1">Edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-error action-delete-btn" onclick="confirmDelete('T11')">
                                        <i class='bx bx-trash'></i>
                                        <span class="hidden sm:inline ml-1">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="pagination" id="paginationNav">
                <div class="text-sm text-base-content/70" id="paginationInfo">
                    Menampilkan 1-5 dari 11 meja
                </div>
                <div class="pagination-buttons">
                    <button class="btn btn-sm btn-outline pagination-button" id="prevPage" disabled>Sebelumnya</button>
                    <button class="btn btn-sm btn-outline pagination-button" id="nextPage">Selanjutnya</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add/Edit Table Modal -->
    <dialog id="tableModal" class="modal">
        <div class="modal-box max-w-md">
            <h3 class="font-bold text-lg mb-4" id="modalTitle">Tambah Meja Baru</h3>
            <form id="tableForm" class="space-y-4">
                <input type="hidden" id="isEditMode" value="false">
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Nomor Meja</span>
                    </label>
                    <input type="text" id="tableNumber" class="input input-bordered" required>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tipe Meja</span>
                    </label>
                    <select id="tableType" class="select select-bordered" required>
                        <option value="">Pilih Tipe Meja</option>
                        <option value="Persegi">Persegi</option>
                        <option value="Persegi Panjang">Persegi Panjang</option>
                        <option value="Bundar">Bundar</option>
                        <option value="VIP">VIP</option>
                    </select>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Harga (Rp)</span>
                    </label>
                    <input type="number" id="tablePrice" class="input input-bordered" required>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Status</span>
                    </label>
                    <select id="tableStatus" class="select select-bordered" required>
                        <option value="available">Tersedia</option>
                        <option value="booked">Dipesan</option>
                    </select>
                </div>
                
                <div class="modal-action">
                    <button type="button" class="btn btn-outline" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn btn-primary" id="saveButton">Simpan</button>
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
            <h3 class="font-bold text-lg mb-4">Konfirmasi Hapus Meja</h3>
            <p>Apakah Anda yakin ingin menghapus meja <span id="deleteTableNumber" class="font-bold"></span>?</p>
            <p class="text-error text-sm mt-2">Tindakan ini tidak dapat dibatalkan.</p>
            <div class="modal-action">
                <button class="btn btn-outline" onclick="closeDeleteModal()">Batal</button>
                <button class="btn btn-error" onclick="deleteTable()">Hapus</button>
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
            const tableModal = document.getElementById('tableModal');
            const deleteConfirmModal = document.getElementById('deleteConfirmModal');
            const tableForm = document.getElementById('tableForm');
            const statusFilter = document.getElementById('statusFilter');
            
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
            
            // Handle table form submission
            tableForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const isEditMode = document.getElementById('isEditMode').value === 'true';
                const tableNumber = document.getElementById('tableNumber').value;
                const tableType = document.getElementById('tableType').value;
                const tablePrice = document.getElementById('tablePrice').value;
                const tableStatus = document.getElementById('tableStatus').value;
                
                // Here you would normally make an AJAX request to save the table data
                console.log(`${isEditMode ? 'Updating' : 'Adding'} table ${tableNumber} with type: ${tableType}, price: ${tablePrice}, status: ${tableStatus}`);
                
                // Show success notification (in a real app)
                alert(`Data meja berhasil ${isEditMode ? 'diperbarui' : 'ditambahkan'}!`);
                
                // Close the modal
                tableModal.close();
            });
            
            // Status filter functionality
            statusFilter.addEventListener('change', function() {
                const filterValue = this.value.toLowerCase();
                const rows = document.querySelectorAll('.table-data-table tbody tr');
                
                rows.forEach(row => {
                    const statusCell = row.cells[3].querySelector('.table-status');
                    const statusClass = Array.from(statusCell.classList).find(cls => cls.startsWith('status-'));
                    const status = statusClass ? statusClass.replace('status-', '') : '';
                    
                    if (filterValue === '' || status === filterValue) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
            
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                const searchText = this.value.toLowerCase();
                const rows = document.querySelectorAll('.table-data-table tbody tr');
                
                rows.forEach(row => {
                    const tableNumber = row.cells[0].textContent.toLowerCase();
                    const tableType = row.cells[1].textContent.toLowerCase();
                    
                    if (tableNumber.includes(searchText) || tableType.includes(searchText)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
            
            // PAGINATION LOGIC
            const rows = document.querySelectorAll('.table-data-table tbody tr');
            const rowsPerPage = 5;
            let currentPage = 1;
            const totalRows = rows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            const paginationInfo = document.getElementById('paginationInfo');
            const prevPageBtn = document.getElementById('prevPage');
            const nextPageBtn = document.getElementById('nextPage');

            function showPage(page) {
                // Hide all rows
                rows.forEach(row => row.style.display = 'none');
                // Show only rows for this page
                const start = (page - 1) * rowsPerPage;
                const end = Math.min(start + rowsPerPage, totalRows);
                for (let i = start; i < end; i++) {
                    rows[i].style.display = '';
                }
                // Update info
                paginationInfo.textContent = `Menampilkan ${start + 1}-${end} dari ${totalRows} meja`;
                // Update button state
                prevPageBtn.disabled = page === 1;
                nextPageBtn.disabled = page === totalPages;
            }

            prevPageBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                }
            });
            nextPageBtn.addEventListener('click', function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    showPage(currentPage);
                }
            });
            // Inisialisasi
            showPage(currentPage);
        });
        
        // Function to open add modal
        function openAddModal() {
            const modal = document.getElementById('tableModal');
            const form = document.getElementById('tableForm');
            const modalTitle = document.getElementById('modalTitle');
            const saveButton = document.getElementById('saveButton');
            const isEditMode = document.getElementById('isEditMode');
            
            // Reset form
            form.reset();
            
            // Set mode to add
            isEditMode.value = 'false';
            modalTitle.textContent = 'Tambah Meja Baru';
            saveButton.textContent = 'Simpan';
            
            // Enable table number field
            document.getElementById('tableNumber').disabled = false;
            
            // Open modal
            modal.showModal();
        }
        
        // Function to open edit modal
        function openEditModal(tableNumber, tableType, tablePrice, tableStatus) {
            const modal = document.getElementById('tableModal');
            const modalTitle = document.getElementById('modalTitle');
            const saveButton = document.getElementById('saveButton');
            const isEditMode = document.getElementById('isEditMode');
            
            // Set mode to edit
            isEditMode.value = 'true';
            modalTitle.textContent = 'Edit Data Meja';
            saveButton.textContent = 'Simpan Perubahan';
            
            // Set values in form
            document.getElementById('tableNumber').value = tableNumber;
            document.getElementById('tableNumber').disabled = true; // Disable editing table number
            document.getElementById('tableType').value = tableType;
            document.getElementById('tablePrice').value = tablePrice;
            document.getElementById('tableStatus').value = tableStatus;
            
            // Open modal
            modal.showModal();
        }
        
        // Function to close modal
        function closeModal() {
            const modal = document.getElementById('tableModal');
            modal.close();
        }
        
        // Function to open delete confirmation modal
        function confirmDelete(tableNumber) {
            const modal = document.getElementById('deleteConfirmModal');
            
            // Set table number in confirmation message
            document.getElementById('deleteTableNumber').textContent = tableNumber;
            
            // Store table number for deletion
            window.tableToDelete = tableNumber;
            
            // Open modal
            modal.showModal();
        }
        
        // Function to close delete modal
        function closeDeleteModal() {
            const modal = document.getElementById('deleteConfirmModal');
            modal.close();
        }
        
        // Function to delete table
        function deleteTable() {
            const tableNumber = window.tableToDelete;
            
            // Here you would normally make an AJAX request to delete the table
            console.log(`Deleting table with number: ${tableNumber}`);
            
            // Show success notification (in a real app)
            alert('Data meja berhasil dihapus!');
            
            // Close the modal
            closeDeleteModal();
            
            // Remove the row from the table (for demo purposes)
            const rows = document.querySelectorAll('.table-data-table tbody tr');
            rows.forEach(row => {
                if (row.cells[0].textContent === tableNumber) {
                    row.remove();
                }
            });
        }
    </script>
</body>
</html> 