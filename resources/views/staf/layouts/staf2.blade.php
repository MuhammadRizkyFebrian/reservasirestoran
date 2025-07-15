<!DOCTYPE html>
<html lang="id" data-theme="lemonade">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Seatify</title>

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
            background-color: var(--fallback-b1, oklch(var(--b1)));
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
            background-color: var(--fallback-primary, oklch(var(--p)));
            color: white;
            font-weight: 500;
        }

        .menu-item:hover:not(.active) {
            background-color: var(--fallback-base-300, oklch(var(--b3)/0.1));
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
            background-color: var(--fallback-primary, oklch(var(--p)));
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
            background-color: var(--fallback-base-100, oklch(var(--b1)));
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
            background-color: var(--fallback-primary, oklch(var(--p)));
            color: var(--fallback-primary-content, oklch(var(--pc)));
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
            box-shadow: 0 0 0 2px var(--fallback-primary, oklch(var(--p)/0.3));
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

        /* Theme Switcher */
        .theme-switcher {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 1000;
            background-color: var(--fallback-base-200, oklch(var(--b2)));
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

        /* Tambahan styling untuk konten spesifik */
        @yield('additional_styles')
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
    @include('staf.layouts.sidebar')

    <!-- Main Content -->
    <div class="content-wrapper" id="contentWrapper">
        <div class="header">
            <h1 class="text-3xl font-bold">@yield('page_title')</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline logout-btn">
                    <i class='bx bx-log-out mr-2'></i>
                    Keluar
                </button>
            </form>
        </div>

        @yield('content')
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

    @yield('modals')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const closeMobileMenu = document.getElementById('closeMobileMenu');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

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
                if (window.innerWidth > 1024) {
                    closeSidebar();
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
        });

        @yield('scripts')
    </script>
</body>

</html>