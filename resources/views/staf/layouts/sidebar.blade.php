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
        <a href="{{ route('staf.dashboard') }}" class="menu-item {{ request()->routeIs('staf.dashboard') ? 'active' : '' }}">
            <i class='bx bxs-dashboard'></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('staf.customers') }}" class="menu-item {{ request()->routeIs('staf.customers') ? 'active' : '' }}">
            <i class='bx bx-user'></i>
            <span>Pelanggan</span>
        </a>

        <a href="{{ route('staf.tables') }}" class="menu-item {{ request()->routeIs('staf.tables') ? 'active' : '' }}">
            <i class='bx bx-table'></i>
            <span>Daftar Meja</span>
        </a>

        <a href="{{ route('staf.menu') }}" class="menu-item {{ request()->routeIs('staf.menu') ? 'active' : '' }}">
            <i class='bx bx-food-menu'></i>
            <span>Daftar Menu</span>
        </a>

        <a href="{{ route('staf.pemesanan') }}" class="menu-item {{ request()->routeIs('staf.pemesanan') ? 'active' : '' }}">
            <i class='bx bx-calendar-edit'></i>
            <span>Pemesanan</span>
        </a>

        <a href="{{ route('staf.transactions') }}" class="menu-item {{ request()->routeIs('staf.transactions') ? 'active' : '' }}">
            <i class='bx bx-history'></i>
            <span>Transaksi Selesai</span>
        </a>
    </div>
</div>