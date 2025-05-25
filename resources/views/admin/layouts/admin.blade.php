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

<body>
    {{-- Mobile menu toggle button --}}
    <div class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class='bx bx-menu'></i>
    </div>

    {{-- Sidebar --}}
    @include('admin.layouts.sidebar')

    {{-- Sidebar overlay (for mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Main Content --}}
    <div class="content-wrapper" id="contentWrapper">
        {{-- Header --}}
        <header class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold">@yield('page-title', 'Dashboard')</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline">
                    <i class='bx bx-log-out mr-2'></i>Keluar
                </button>
            </form>
        </header>

        {{-- Page content --}}
        @yield('content')
    </div>

    {{-- Scripts --}}
    <script>
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const closeMobileMenu = document.getElementById('closeMobileMenu');

        mobileMenuToggle.addEventListener('click', () => {
            sidebar.classList.add('active');
            sidebarOverlay.classList.add('active');
        });

        if (closeMobileMenu) {
            closeMobileMenu.addEventListener('click', () => {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });
        }

        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });

        setTimeout(() => {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => alert.style.display = 'none');
        }, 5000);

    </script>
    @stack('scripts')
</body>
</html>
