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
            color: var(--fallback-primary-content, oklch(var(--pc)));
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

        .table-data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 0.75rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .table-data-table th {
            background-color: var(--fallback-base-200, oklch(var(--b2)));
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .table-data-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--fallback-base-300, oklch(var(--b3)/0.1));
        }

        .table-data-table tr:last-child td {
            border-bottom: none;
        }

        .table-data-table tr {
            transition: all 0.3s ease;
        }

        .table-data-table tr:hover {
            background-color: var(--fallback-base-300, oklch(var(--b3)/0.1));
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
            color: var(--fallback-success, oklch(var(--su)));
        }

        .status-booked {
            background-color: rgba(var(--error-rgb, 200, 0, 0), 0.15);
            color: var(--fallback-error, oklch(var(--er)));
        }


        .action-edit-btn,
        .action-delete-btn {
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

            .table-data-table th,
            .table-data-table td {
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
                <span>Transaksi Selesai</span>
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

        <!-- Notifikasi -->
        <div id="notification" class="toast toast-end hidden">
            <div class="alert shadow-lg">
                <i class='bx bx-check-circle'></i>
                <span id="notificationMessage"></span>
            </div>
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
                        <option value="tersedia">Tersedia</option>
                        <option value="dipesan">Dipesan</option>
                    </select>
                    <button type="button" class="btn btn-primary" onclick="filterTable()">
                        <i class='bx bx-search'></i>
                        Cari
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
                            <th>Kapasitas</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($meja as $index => $table)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ ucfirst($table->tipe_meja) }}</td>
                            <td>{{ $table->kapasitas }} orang</td>
                            <td>Rp{{ number_format($table->harga, 0, ',', '.') }}</td>
                            <td>
                                <button onclick="showSchedule('{{ $table->no_meja }}')"
                                    class="btn btn-sm {{ $table->status === 'tersedia' ? 'btn-success' : 'btn-error' }}">
                                    {{ ucfirst($table->status) }}
                                    <i class='bx bx-calendar-event ml-1'></i>
                                </button>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('{{ $table->no_meja }}', '{{ $table->tipe_meja }}', '{{ $table->harga }}', '{{ $table->status }}', '{{ $table->kapasitas }}')">
                                        <i class='bx bx-edit-alt'></i>
                                        <span class="hidden sm:inline ml-1">Edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-error action-delete-btn" onclick="confirmDelete('{{ $table->no_meja }}')">
                                        <i class='bx bx-trash'></i>
                                        <span class="hidden sm:inline ml-1">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                Tidak ada data meja
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <div class="text-sm text-base-content/70">
                    Menampilkan {{ $meja->firstItem() }}-{{ $meja->lastItem() }} dari {{ $meja->total() }} meja
                </div>
                <div class="pagination-buttons">
                    @if ($meja->onFirstPage())
                    <button class="btn btn-sm btn-outline pagination-button" disabled>
                        <i class='bx bx-chevron-left'></i>
                        <span>Sebelumnya</span>
                    </button>
                    @else
                    <a href="{{ $meja->previousPageUrl() }}" class="btn btn-sm btn-outline pagination-button">
                        <i class='bx bx-chevron-left'></i>
                        <span>Sebelumnya</span>
                    </a>
                    @endif

                    @if ($meja->hasMorePages())
                    <a href="{{ $meja->nextPageUrl() }}" class="btn btn-sm btn-outline pagination-button">
                        <span>Selanjutnya</span>
                        <i class='bx bx-chevron-right'></i>
                    </a>
                    @else
                    <button class="btn btn-sm btn-outline pagination-button" disabled>
                        <span>Selanjutnya</span>
                        <i class='bx bx-chevron-right'></i>
                    </button>
                    @endif
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
                        <span class="label-text">Kapasitas (Orang)</span>
                    </label>
                    <input type="number" id="tableCapacity" class="input input-bordered" min="1" required>
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
                        <option value="tersedia">Tersedia</option>
                        <option value="dipesan">Dipesan</option>
                    </select>
                </div>

                <div class="modal-action">
                    <button type="button" class="btn btn-outline" onclick="closeEditModal()">Batal</button>
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

    <!-- Modal Detail Jadwal -->
    <dialog id="scheduleModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Detail Jadwal Meja <span id="tableNumber"></span></h3>
            <div id="scheduleContent" class="space-y-4">
                <!-- Jadwal akan ditampilkan di sini -->
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Tutup</button>
                </form>
            </div>
        </div>
    </dialog>

    <script>
        // Fungsi untuk membuka modal tambah
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
            document.getElementById('tableNumber').readOnly = false;

            // Open modal
            modal.showModal();
        }

        // Fungsi untuk membuka modal edit
        function openEditModal(noMeja, tipeMeja, harga, status, kapasitas) {
            console.log('Edit modal opened with:', {
                noMeja,
                tipeMeja,
                harga,
                status,
                kapasitas
            });

            const modal = document.getElementById('tableModal');
            const modalTitle = document.getElementById('modalTitle');
            const isEditMode = document.getElementById('isEditMode');
            const tableNumber = document.getElementById('tableNumber');
            const tableType = document.getElementById('tableType');
            const tableCapacity = document.getElementById('tableCapacity');
            const tablePrice = document.getElementById('tablePrice');
            const tableStatus = document.getElementById('tableStatus');

            // Set mode edit
            isEditMode.value = 'true';
            modalTitle.textContent = 'Edit Meja';

            // Set nilai form
            tableNumber.value = noMeja;
            tableType.value = tipeMeja.charAt(0).toUpperCase() + tipeMeja.slice(1);
            tableCapacity.value = kapasitas;
            tablePrice.value = harga;
            tableStatus.value = status;

            // Disable nomor meja
            tableNumber.readOnly = true;

            // Buka modal
            modal.showModal();
        }

        // Fungsi untuk menutup modal edit
        function closeEditModal() {
            document.getElementById('tableModal').close();
        }

        // Fungsi untuk konfirmasi hapus
        function confirmDelete(noMeja) {
            console.log('Confirm delete for:', noMeja);

            const modal = document.getElementById('deleteConfirmModal');
            const deleteTableNumber = document.getElementById('deleteTableNumber');

            // Simpan nomor meja yang akan dihapus
            window.tableToDelete = noMeja;

            // Set nomor meja di pesan konfirmasi
            deleteTableNumber.textContent = noMeja;

            // Buka modal konfirmasi
            modal.showModal();
        }

        // Fungsi untuk menutup modal hapus
        function closeDeleteModal() {
            document.getElementById('deleteConfirmModal').close();
        }

        // Fungsi untuk menghapus meja
        function deleteTable() {
            const tableNumber = window.tableToDelete;
            console.log('Deleting table:', tableNumber);

            fetch('{{ route("admin.tables.delete") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        no_meja: tableNumber,
                        _token: '{{ csrf_token() }}'
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Terjadi kesalahan saat menghapus meja');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Hapus baris dari tabel
                    removeTableRow(tableNumber);

                    // Tampilkan notifikasi
                    showNotification('Meja berhasil dihapus', 'alert-success');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification(error.message, 'alert-error');
                });

            // Tutup modal
            closeDeleteModal();
        }

        // Fungsi untuk memperbarui data tabel
        function updateTableRow(tableData, isNewData = false) {
            console.log('Updating table row:', {
                tableData,
                isNewData
            });

            const tableBody = document.querySelector('.table-data-table tbody');

            if (isNewData) {
                // Jika tidak ada data, hapus pesan "Tidak ada data meja"
                const emptyRow = tableBody.querySelector('tr td[colspan="6"]');
                if (emptyRow) {
                    emptyRow.parentElement.remove();
                }

                // Tambah baris baru
                const newRow = document.createElement('tr');

                newRow.innerHTML = `
                    <td>${tableData.no_meja}</td>
                    <td>${tableData.tipe_meja.charAt(0).toUpperCase() + tableData.tipe_meja.slice(1)}</td>
                    <td>${tableData.kapasitas} Orang</td>
                    <td>Rp${new Intl.NumberFormat('id-ID').format(tableData.harga)}</td>
                    <td>
                        <button onclick="showSchedule(${tableData.no_meja})"
                            class="btn btn-sm ${tableData.status === 'tersedia' ? 'btn-success' : 'btn-error'}">
                            ${tableData.status.charAt(0).toUpperCase() + tableData.status.slice(1)}
                            <i class='bx bx-calendar-event ml-1'></i>
                        </button>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('${tableData.no_meja}', '${tableData.tipe_meja}', '${tableData.harga}', '${tableData.status}', '${tableData.kapasitas}')">
                                <i class='bx bx-edit-alt'></i>
                                <span class="hidden sm:inline ml-1">Edit</span>
                            </button>
                            <button class="btn btn-sm btn-error action-delete-btn" onclick="confirmDelete('${tableData.no_meja}')">
                                <i class='bx bx-trash'></i>
                                <span class="hidden sm:inline ml-1">Hapus</span>
                            </button>
                        </div>
                    </td>
                `;

                tableBody.appendChild(newRow);
            } else {
                // Update baris yang sudah ada
                const rows = tableBody.querySelectorAll('tr');
                rows.forEach(row => {
                    const cells = row.cells;
                    if (cells[0].textContent === tableData.no_meja) {
                        cells[1].textContent = tableData.tipe_meja.charAt(0).toUpperCase() + tableData.tipe_meja.slice(1);
                        cells[2].textContent = `${tableData.kapasitas} Orang`;
                        cells[3].textContent = `Rp${new Intl.NumberFormat('id-ID').format(tableData.harga)}`;
                        cells[4].innerHTML = `
                            <button onclick="showSchedule(${tableData.no_meja})"
                                class="btn btn-sm ${tableData.status === 'tersedia' ? 'btn-success' : 'btn-error'}">
                                ${tableData.status.charAt(0).toUpperCase() + tableData.status.slice(1)}
                                <i class='bx bx-calendar-event ml-1'></i>
                            </button>
                        `;
                        cells[5].innerHTML = `
                            <div class="action-buttons">
                                <button class="btn btn-sm btn-primary action-edit-btn" onclick="openEditModal('${tableData.no_meja}', '${tableData.tipe_meja}', '${tableData.harga}', '${tableData.status}', '${tableData.kapasitas}')">
                                    <i class='bx bx-edit-alt'></i>
                                    <span class="hidden sm:inline ml-1">Edit</span>
                                </button>
                                <button class="btn btn-sm btn-error action-delete-btn" onclick="confirmDelete('${tableData.no_meja}')">
                                    <i class='bx bx-trash'></i>
                                    <span class="hidden sm:inline ml-1">Hapus</span>
                                </button>
                            </div>
                        `;
                    }
                });
            }
        }

        // Fungsi untuk menghapus baris tabel
        function removeTableRow(tableNumber) {
            console.log('Removing table row:', tableNumber);

            const tableBody = document.querySelector('.table-data-table tbody');
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                if (row.cells[0].textContent === tableNumber) {
                    row.remove();

                    // Cek jika tabel kosong
                    const remainingRows = tableBody.querySelectorAll('tr');
                    if (remainingRows.length === 0) {
                        const emptyRow = document.createElement('tr');
                        emptyRow.innerHTML = `
                            <td colspan="6" class="text-center py-4">
                                Tidak ada data meja
                            </td>
                        `;
                        tableBody.appendChild(emptyRow);
                    }
                }
            });
        }

        // Fungsi untuk menampilkan notifikasi
        function showNotification(message, type = 'alert-success') {
            const notification = document.getElementById('notification');
            const notificationMessage = notification.querySelector('span');
            const alert = notification.querySelector('.alert');

            // Set pesan dan tipe alert
            notificationMessage.textContent = message;
            alert.className = `alert shadow-lg ${type}`;

            // Tampilkan notifikasi
            notification.classList.remove('hidden');

            // Sembunyikan notifikasi setelah 3 detik
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 3000);
        }

        // Event listener saat dokumen dimuat
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

            // Handle form submission
            tableForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const isEditMode = document.getElementById('isEditMode').value === 'true';
                const tableNumber = document.getElementById('tableNumber').value;
                const tableType = document.getElementById('tableType').value;
                const tableCapacity = document.getElementById('tableCapacity').value;
                const tablePrice = document.getElementById('tablePrice').value;
                const tableStatus = document.getElementById('tableStatus').value;

                const tableData = {
                    no_meja: tableNumber,
                    tipe_meja: tableType.toLowerCase(),
                    kapasitas: parseInt(tableCapacity),
                    harga: tablePrice,
                    status: tableStatus
                };

                const endpoint = isEditMode ?
                    '{{ route("admin.tables.update") }}' :
                    '{{ route("admin.tables.create") }}';

                fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            ...tableData,
                            _token: '{{ csrf_token() }}'
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                const errorMessage = data.message.includes('The no meja has already been taken') ?
                                    'Nomor meja sudah digunakan' : data.message;
                                throw new Error(errorMessage);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Update tabel
                        updateTableRow(tableData, !isEditMode);

                        // Tampilkan notifikasi
                        showNotification(data.message, 'alert-success');

                        // Tutup modal
                        document.getElementById('tableModal').close();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification(error.message, 'alert-error');
                    });
            });

            // Search and filter functionality
            const searchInput = document.getElementById('searchInput');
            const rows = document.querySelectorAll('.table-data-table tbody tr');

            function filterTable() {
                const searchText = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value.toLowerCase();

                rows.forEach(row => {
                    const noMeja = row.cells[0].textContent.toLowerCase();
                    const tipeMeja = row.cells[1].textContent.toLowerCase();
                    const status = row.cells[4].textContent.toLowerCase().trim();

                    const matchesSearch = noMeja.includes(searchText) || tipeMeja.includes(searchText);
                    const matchesStatus = statusValue === '' || status.includes(statusValue);

                    if (matchesSearch && matchesStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('input', filterTable);
            statusFilter.addEventListener('change', filterTable);
        });

        async function showSchedule(noMeja) {
            try {
                const response = await fetch(`/admin/tables/${noMeja}/schedule`);
                const data = await response.json();

                if (data.success) {
                    document.getElementById('tableNumber').textContent = noMeja;
                    const scheduleContent = document.getElementById('scheduleContent');

                    if (data.data.length === 0) {
                        scheduleContent.innerHTML = `
                            <div class="text-center py-4 text-gray-500">
                                Tidak ada jadwal pemesanan untuk meja ini
                            </div>
                        `;

                        // Update tampilan status meja menjadi tersedia
                        const statusButton = document.querySelector(`button[onclick="showSchedule(${noMeja})"]`);
                        if (statusButton) {
                            statusButton.className = 'btn btn-sm btn-success';
                            statusButton.innerHTML = `
                                Tersedia
                                <i class='bx bx-calendar-event ml-1'></i>
                            `;
                        }
                    } else {
                        const scheduleHTML = data.data.map(jadwal => {
                            const statusText = jadwal.status === 'dikonfirmasi' ? 'Dikonfirmasi' : 'Menunggu';
                            const badgeClass = jadwal.status === 'dikonfirmasi' ? 'badge-success' : 'badge-warning';

                            return `
                                <div class="bg-base-200 p-4 rounded-lg">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-semibold">${jadwal.tanggal}</span>
                                        <span class="text-sm">${jadwal.waktu}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm">${jadwal.nama_pemesan}</span>
                                        <span class="badge ${badgeClass}">
                                            ${statusText}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Kode: ${jadwal.kode_transaksi}
                                    </div>
                                </div>
                            `;
                        }).join('');

                        scheduleContent.innerHTML = scheduleHTML;

                        // Update tampilan status meja menjadi dipesan
                        const statusButton = document.querySelector(`button[onclick="showSchedule(${noMeja})"]`);
                        if (statusButton) {
                            statusButton.className = 'btn btn-sm btn-error';
                            statusButton.innerHTML = `
                                Dipesan
                                <i class='bx bx-calendar-event ml-1'></i>
                            `;
                        }
                    }

                    document.getElementById('scheduleModal').showModal();
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                alert('Terjadi kesalahan: ' + error.message);
            }
        }
    </script>
</body>

</html>