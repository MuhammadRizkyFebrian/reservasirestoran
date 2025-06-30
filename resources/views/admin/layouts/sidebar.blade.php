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
        <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class='bx bxs-dashboard'></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.customers') }}" class="menu-item {{ request()->routeIs('admin.customers') ? 'active' : '' }}">
            <i class='bx bxs-user-detail'></i>
            <span>Data Pelanggan</span>
        </a>

        <a href="{{ route('admin.tables') }}" class="menu-item {{ request()->routeIs('admin.tables') ? 'active' : '' }}">
            <i class='bx bx-table'></i>
            <span>Daftar Meja</span>
        </a>

        <a href="{{ route('admin.menu') }}" class="menu-item {{ request()->routeIs('admin.menu') ? 'active' : '' }}">
            <i class='bx bx-food-menu'></i>
            <span>Daftar Menu</span>
        </a>

        <a href="{{ route('admin.pemesanan') }}" class="menu-item {{ request()->routeIs('admin.pemesanan') ? 'active' : '' }}">
            <i class='bx bx-calendar-edit'></i>
            <span>Pemesanan</span>
        </a>

        <a href="{{ route('admin.transactions') }}" class="menu-item {{ request()->routeIs('admin.transactions') ? 'active' : '' }}">
            <i class='bx bx-history'></i>
            <span>Transaksi Selesai</span>
        </a>
    </div>
</div>