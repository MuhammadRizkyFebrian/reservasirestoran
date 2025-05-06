<!DOCTYPE html>
<html lang="id" data-theme="lemonade">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Seatify</title>
    
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
            height: 100%;
            min-height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            border-right: 1px solid rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            transition: transform 0.3s ease, width 0.3s ease;
            z-index: 50;
            -webkit-overflow-scrolling: touch;
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
            -webkit-tap-highlight-color: transparent;
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
            width: 48px;
            height: 48px;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            border: none;
            outline: none;
            -webkit-tap-highlight-color: transparent;
        }
        
        .mobile-menu-toggle:active {
            transform: scale(0.95);
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
        }

        .stat-card {
            background-color: var(--fallback-base-200,oklch(var(--b2)));
            padding: 1.5rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            background-color: var(--fallback-primary,oklch(var(--p)/0.2));
            color: var(--fallback-primary,oklch(var(--p)));
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 600;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--fallback-base-content,oklch(var(--bc)/0.7));
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
            -webkit-tap-highlight-color: transparent;
        }
        
        .theme-switcher:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
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
            -webkit-tap-highlight-color: transparent;
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

            .content-wrapper {
                padding: 4rem 1rem 1rem 1rem;
            }
            
            .menu-item {
                padding: 0.875rem;
            }
            
            .menu-item i {
                font-size: 1.4rem;
            }
        }
        
        @media (max-width: 480px) {
            .header h1 {
                font-size: 1.5rem;
            }
            
            .content-wrapper h2 {
                font-size: 1.25rem;
            }

            .stat-card {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }

            .stat-icon {
                margin-bottom: 0.5rem;
            }
            
            .sidebar {
                width: 280px;
                transform: translateX(-280px);
            }
            
            .menu-item {
                padding: 1rem;
                margin-bottom: 0.75rem;
            }
            
            .menu-item i {
                margin-right: 1rem;
                font-size: 1.5rem;
            }
            
            .mobile-menu-toggle {
                width: 42px;
                height: 42px;
            }
        }
        
        /* Fix untuk browser mobile */
        @supports (-webkit-touch-callout: none) {
            .sidebar, .content-wrapper {
                /* Fix untuk iOS Safari 100vh */
                height: -webkit-fill-available;
            }
        }
    </style>
</head>
<body class="font-poppins">
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle Navigation Menu">
        <i class='bx bx-menu text-xl'></i>
    </button>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="py-4 px-4 border-b border-base-200 flex justify-between items-center">
            <h1 class="text-xl font-bold flex items-center">
                <i class='bx bx-store-alt mr-2 text-2xl'></i>
                Seatify Admin
            </h1>
            <button class="btn btn-circle btn-sm btn-ghost lg:hidden" id="closeMobileMenu" aria-label="Close Menu">
                <i class='bx bx-x text-xl'></i>
            </button>
        </div>
        
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item active">
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
            
            <a href="{{ route('admin.transactions') }}" class="menu-item">
                <i class='bx bx-history'></i>
                <span>Riwayat Transaksi</span>
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="content-wrapper" id="contentWrapper">
        <div class="header">
            <h1 class="text-3xl font-bold">Dashboard Admin</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline logout-btn">
                    <i class='bx bx-log-out mr-2'></i>
                    Keluar
                </button>
            </form>
        </div>
        
        <!-- Statistics Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-6">Statistik Ringkasan</h2>
            <div class="stats-grid">
                <!-- Stat Card 1: Jumlah Meja -->
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class='bx bx-table'></i>
                    </div>
                    <div>
                        <div class="stat-value">15</div> <!-- Ganti dengan data dinamis -->
                        <div class="stat-label">Jumlah Meja</div>
                    </div>
                </div>
                
                <!-- Stat Card 2: Jumlah Akun Pelanggan -->
                <div class="stat-card">
                    <div class="stat-icon">
                         <i class='bx bxs-user-account'></i>
                    </div>
                    <div>
                        <div class="stat-value">25</div> <!-- Ganti dengan data dinamis -->
                        <div class="stat-label">Jumlah Akun Pelanggan</div>
                    </div>
                </div>
                
                <!-- Stat Card 3: Jumlah Reservasi -->
                <div class="stat-card">
                    <div class="stat-icon">
                       <i class='bx bx-calendar-check'></i>
                    </div>
                    <div>
                        <div class="stat-value">10</div> <!-- Ganti dengan data dinamis -->
                        <div class="stat-label">Jumlah Reservasi</div>
                    </div>
                </div>

                <!-- Stat Card 4: Transaksi Selesai -->
                 <div class="stat-card">
                    <div class="stat-icon">
                        <i class='bx bx-receipt'></i>
                    </div>
                    <div>
                        <div class="stat-value">3</div> <!-- Ganti dengan data dinamis -->
                        <div class="stat-label">Transaksi Selesai</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tambahkan bagian lain jika perlu, misal: grafik, tabel ringkasan -->

    </div>
    
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
            const menuItems = document.querySelectorAll('.menu-item');
            
            // Mobile Menu Toggle
            mobileMenuToggle.addEventListener('click', () => {
                sidebar.classList.add('active');
                sidebarOverlay.classList.add('active');
                document.body.style.overflow = 'hidden'; // Mencegah scroll body
            });
            
            function closeSidebar() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = ''; // Memungkinkan scroll body
            }
            
            closeMobileMenu.addEventListener('click', closeSidebar);
            sidebarOverlay.addEventListener('click', closeSidebar);
            
            // Menu item click on mobile - close sidebar
            if (window.innerWidth <= 1024) {
                menuItems.forEach(item => {
                    item.addEventListener('click', () => {
                        setTimeout(closeSidebar, 150);
                    });
                });
            }
            
            // Resize handler
            window.addEventListener('resize', () => {
                if (window.innerWidth > 1024) {
                    closeSidebar();
                    document.body.style.overflow = '';
                }
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
            
            // Deteksi apakah perangkat mendukung hover
            function hasHoverSupport() {
                return window.matchMedia('(hover: hover)').matches;
            }
            
            // Tambahkan kelas khusus untuk perangkat tanpa hover
            if (!hasHoverSupport()) {
                document.body.classList.add('no-hover-device');
                
                // Untuk perangkat tanpa hover, tambahkan click effect
                menuItems.forEach(item => {
                    if (!item.classList.contains('active')) {
                        item.addEventListener('touchstart', function() {
                            this.classList.add('touch-active');
                        });
                        
                        item.addEventListener('touchend', function() {
                            setTimeout(() => {
                                this.classList.remove('touch-active');
                            }, 150);
                        });
                    }
                });
            }
            
            // Fix untuk bar browser yang bisa berubah tinggi di perangkat mobile
            function setMobileHeight() {
                const vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--vh', `${vh}px`);
            }
            
            setMobileHeight();
            window.addEventListener('resize', setMobileHeight);
        });
    </script>
</body>
</html> 