<!DOCTYPE html>
<html lang="id" data-theme="lemonade">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Pemesanan - Seatify</title>

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

        .reservation-table {
            /* Ganti dari customer-table */
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 0.75rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .reservation-table th {
            background-color: var(--fallback-base-200, oklch(var(--b2)));
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .reservation-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--fallback-base-300, oklch(var(--b3)/0.1));
        }

        .reservation-table tr:last-child td {
            border-bottom: none;
        }

        .reservation-table tr {
            transition: all 0.3s ease;
        }

        .reservation-table tr:hover {
            background-color: var(--fallback-base-300, oklch(var(--b3)/0.1));
        }

        .reservation-table td .action-buttons {
            display: flex;
            gap: 0.5rem;
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

        /* Status Pemesanan */
        .table-status {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
        }

        .status-pending {
            background-color: rgba(255, 165, 0, 0.15);
            /* Orange */
            color: #FFA500;
        }

        .status-confirmed {
            background-color: rgba(0, 200, 0, 0.15);
            /* Green */
            color: #00C800;
        }

        .status-completed {
            background-color: rgba(0, 100, 200, 0.15);
            /* Blue */
            color: #0064C8;
        }

        .status-cancelled {
            background-color: rgba(200, 0, 0, 0.15);
            /* Red */
            color: #C80000;
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

            .reservation-table {
                /* Ganti dari customer-table */
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

            .reservation-table th,
            .reservation-table td {
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

            <a href="{{ route('admin.tables') }}" class="menu-item ">
                <i class='bx bx-table'></i>
                <span>Daftar Meja</span>
            </a>

            <a href="{{ route('admin.menu') }}" class="menu-item">
                <i class='bx  bx-food-menu'></i>
                <span>Daftar Menu</span>
            </a>

            <a href="{{ route('admin.pemesanan') }}" class="menu-item active">
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
            <h1 class="text-3xl font-bold">Data Pemesanan</h1>
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
                <i class='bx bx-calendar mr-2 text-primary'></i>
                Daftar Pemesanan
            </h2>

            <!-- Search & Filter Form -->
            <div class="search-form">
                <input type="text" placeholder="Cari pemesanan..." class="input input-bordered" id="searchInput">
                <button class="btn btn-primary">
                    <i class='bx bx-search mr-1'></i>
                    <span>Cari</span>
                </button>
            </div>

            <!-- Reservation Table -->
            <div class="overflow-x-auto">
                <table class="reservation-table">
                    <thead>
                        <tr>
                            <th>Kode Transaksi</th>
                            <th>Nama Pemesan</th>
                            <th>No. Meja</th>
                            <th>Jumlah Tamu</th>
                            <th>No. Handphone</th>
                            <th>Jadwal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pemesanan as $p)
                        <tr>
                            <td>{{ $p->kode_transaksi }}</td>
                            <td>{{ $p->nama_pemesan }}</td>
                            <td>{{ $p->nomor_meja }}</td>
                            <td>{{ $p->jumlah_tamu }}</td>
                            <td>{{ $p->no_handphone }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->jadwal)->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge {{ 
                                    $p->status == 'selesai' ? 'badge-info' : 
                                    ($p->status == 'dibatalkan' ? 'badge-error' : 
                                    ($p->status == 'dikonfirmasi' ? 'badge-success' : 
                                    'badge-warning')) 
                                }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button onclick="showDetail('{{ $p->kode_transaksi }}')" class="btn btn-sm btn-info">
                                        <i class='bx bx-info-circle'></i>
                                    </button>
                                    @if($p->status == 'menunggu' && $p->pembayaran && $p->pembayaran->bukti_pembayaran)
                                    <button onclick="showConfirmation('{{ $p->kode_transaksi }}')" class="btn btn-sm btn-success ml-2">
                                        <i class='bx bx-check'></i>
                                    </button>
                                    @endif
                                    @if($p->status == 'menunggu')
                                    <button onclick="showCancellation('{{ $p->kode_transaksi }}')" class="btn btn-sm btn-error ml-2">
                                        <i class='bx bx-x'></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                Tidak ada data pemesanan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <div class="text-sm text-base-content/70">
                    Menampilkan {{ $pemesanan->firstItem() }}-{{ $pemesanan->lastItem() }} dari {{ $pemesanan->total() }} pemesanan
                </div>
                <div class="pagination-buttons">
                    @if ($pemesanan->onFirstPage())
                    <button class="btn btn-sm btn-outline pagination-button" disabled>
                        <i class='bx bx-chevron-left'></i>
                        <span>Sebelumnya</span>
                    </button>
                    @else
                    <a href="{{ $pemesanan->previousPageUrl() }}" class="btn btn-sm btn-outline pagination-button">
                        <i class='bx bx-chevron-left'></i>
                        <span>Sebelumnya</span>
                    </a>
                    @endif

                    @if ($pemesanan->hasMorePages())
                    <a href="{{ $pemesanan->nextPageUrl() }}" class="btn btn-sm btn-outline pagination-button">
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

    <!-- Edit Reservation Modal -->
    <dialog id="editReservationModal" class="modal">
        <div class="modal-box max-w-lg"> <!-- Sedikit lebih lebar -->
            <h3 class="font-bold text-lg mb-4">Edit Data Pemesanan</h3>
            <form id="editReservationForm" class="space-y-4">
                <input type="hidden" id="reservationId">

                <div class="form-control">
                    <label class="label"><span class="label-text">ID Pemesanan</span></label>
                    <input type="text" id="reservationIdDisplay" class="input input-bordered" disabled>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text">Nama Pemesan</span></label>
                    <input type="text" id="customerName" class="input input-bordered" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Tanggal & Waktu</span></label>
                        <input type="datetime-local" id="reservationDateTime" class="input input-bordered" required>
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Meja</span></label>
                        <!-- Ganti dengan select dinamis dari data meja -->
                        <select id="reservationTable" class="select select-bordered" required>
                            <option value="">Pilih Meja</option>
                            <option value="T1">T1 - Persegi</option>
                            <option value="T2">T2 - Persegi</option>
                            <option value="T3">T3 - Persegi</option>
                            <option value="T4">T4 - Persegi</option>
                            <option value="T5">T5 - Bundar</option>
                            <option value="T6">T6 - Bundar</option>
                            <option value="T7">T7 - Bundar</option>
                            <option value="T8">T8 - Persegi Panjang</option>
                            <option value="T9">T9 - Persegi Panjang</option>
                            <option value="T10">T10 - Persegi Panjang</option>
                            <option value="T11">T11 - VIP</option>
                        </select>
                    </div>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text">Status Pemesanan</span></label>
                    <select id="reservationStatus" class="select select-bordered" required>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Dikonfirmasi</option>
                        <option value="completed">Selesai</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
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
            <h3 class="font-bold text-lg mb-4">Konfirmasi Hapus Pemesanan</h3>
            <p>Apakah Anda yakin ingin menghapus data pemesanan <span id="deleteReservationId" class="font-bold"></span>?</p>
            <p class="text-error text-sm mt-2">Tindakan ini tidak dapat dibatalkan.</p>
            <div class="modal-action">
                <button class="btn btn-outline" onclick="closeDeleteModal()">Batal</button>
                <button class="btn btn-error" onclick="deleteReservation()">Hapus</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <!-- Detail Pemesanan Modal -->
    <dialog id="detail-modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Detail Pemesanan</h3>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Kode Transaksi</p>
                        <p class="font-medium" id="detail-kode"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nama Pemesan</p>
                        <p class="font-medium" id="detail-nama"></p>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nomor Meja</p>
                    <p class="font-medium" id="detail-meja"></p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Jadwal</p>
                        <p class="font-medium" id="detail-jadwal"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status Pemesanan</p>
                        <p class="font-medium" id="detail-status"></p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Status Pembayaran</p>
                        <p class="font-medium" id="detail-pembayaran"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pembayaran</p>
                        <p class="font-medium" id="detail-total"></p>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Bukti Pembayaran</p>
                    <p class="font-medium" id="detail-bukti-text">-</p>
                    <img id="detail-bukti" src="" alt="Bukti Pembayaran" class="mt-2 max-w-full h-auto hidden">
                </div>
            </div>
            <div class="modal-action">
                <button class="btn" onclick="document.getElementById('detail-modal').close()">Tutup</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <!-- Konfirmasi Modal -->
    <dialog id="confirmModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Konfirmasi Pemesanan</h3>
            <p>Apakah Anda yakin ingin mengkonfirmasi pemesanan <span id="confirmReservationId" class="font-bold"></span>?</p>
            <div class="modal-action">
                <button class="btn btn-outline" onclick="closeConfirmModal()">Batal</button>
                <button class="btn btn-success" onclick="confirmReservation()">Konfirmasi</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <!-- Pembatalan Modal -->
    <dialog id="cancelModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Batalkan Pemesanan</h3>
            <p>Apakah Anda yakin ingin membatalkan pemesanan <span id="cancelReservationId" class="font-bold"></span>?</p>
            <p class="text-error text-sm mt-2">Tindakan ini tidak dapat dibatalkan.</p>
            <div class="modal-action">
                <button class="btn btn-outline" onclick="closeCancelModal()">Batal</button>
                <button class="btn btn-error" onclick="cancelReservation()">Ya, Batalkan</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <!-- Notifikasi -->
    <div id="notification" class="toast toast-end hidden">
        <div class="alert shadow-lg">
            <i class='bx bx-check-circle'></i>
            <span id="notificationMessage"></span>
        </div>
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
            const editReservationModal = document.getElementById('editReservationModal');
            const deleteConfirmModal = document.getElementById('deleteConfirmModal');
            const editReservationForm = document.getElementById('editReservationForm');

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

            // Edit Form Submission
            editReservationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const reservationId = document.getElementById('reservationId').value;
                const customerName = document.getElementById('customerName').value;
                const dateTime = document.getElementById('reservationDateTime').value;
                const table = document.getElementById('reservationTable').value;
                const status = document.getElementById('reservationStatus').value;

                // Simulate AJAX request
                console.log(`Updating reservation ${reservationId}: Name=${customerName}, DateTime=${dateTime}, Table=${table}, Status=${status}`);
                alert('Data pemesanan berhasil diperbarui!');
                editReservationModal.close();
            });

            // Search Functionality (Simple Example)
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                const searchText = this.value.toLowerCase();
                const rows = document.querySelectorAll('.reservation-table tbody tr');

                rows.forEach(row => {
                    const reservationId = row.cells[0].textContent.toLowerCase();
                    const customerName = row.cells[1].textContent.toLowerCase();
                    row.style.display = (reservationId.includes(searchText) || customerName.includes(searchText)) ? '' : 'none';
                });
            });
        });

        // Modal Functions
        function openEditModal(id, name, dateTime, table, status) {
            const modal = document.getElementById('editReservationModal');
            document.getElementById('reservationId').value = id;
            document.getElementById('reservationIdDisplay').value = id; // Display ID
            document.getElementById('customerName').value = name;
            document.getElementById('reservationDateTime').value = dateTime;
            document.getElementById('reservationTable').value = table;
            document.getElementById('reservationStatus').value = status;
            modal.showModal();
        }

        function closeEditModal() {
            document.getElementById('editReservationModal').close();
        }

        function confirmDelete(id) {
            const modal = document.getElementById('deleteConfirmModal');
            document.getElementById('deleteReservationId').textContent = id;
            window.reservationToDelete = id; // Store ID for deletion
            modal.showModal();
        }

        function closeDeleteModal() {
            document.getElementById('deleteConfirmModal').close();
        }

        function deleteReservation() {
            const id = window.reservationToDelete;
            // Simulate AJAX request
            console.log(`Deleting reservation with ID: ${id}`);
            alert('Data pemesanan berhasil dihapus!');
            closeDeleteModal();

            // Remove row from table (demo only)
            document.querySelectorAll('.reservation-table tbody tr').forEach(row => {
                if (row.cells[0].textContent === id) {
                    row.remove();
                }
            });
        }

        function showDetail(kodeTransaksi) {
            // Tampilkan modal detail
            const modal = document.getElementById('detail-modal');
            modal.showModal();

            // Ambil data detail pemesanan
            fetch(`/admin/pemesanan/${kodeTransaksi}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Isi data ke dalam modal
                        document.getElementById('detail-kode').textContent = data.data.kode_transaksi;
                        document.getElementById('detail-nama').textContent = data.data.nama_pemesan;
                        document.getElementById('detail-meja').textContent = data.data.nomor_meja;
                        document.getElementById('detail-jadwal').textContent = data.data.jadwal;

                        // Set status dengan badge
                        const statusBadgeClass =
                            data.data.status_pemesanan.toLowerCase() === 'selesai' ? 'badge-info' :
                            data.data.status_pemesanan.toLowerCase() === 'dibatalkan' ? 'badge-error' :
                            data.data.status_pemesanan.toLowerCase() === 'dikonfirmasi' ? 'badge-success' :
                            'badge-warning';
                        document.getElementById('detail-status').innerHTML = `<span class="badge ${statusBadgeClass}">${data.data.status_pemesanan}</span>`;

                        // Set status pembayaran dengan badge
                        const paymentStatus = data.data.status_pembayaran.toLowerCase();
                        const paymentBadgeClass =
                            paymentStatus === 'dikonfirmasi' ? 'badge-success' :
                            paymentStatus === 'selesai' ? 'badge-info' :
                            paymentStatus === 'dibatalkan' ? 'badge-error' :
                            paymentStatus === 'belum bayar' ? 'badge-warning' :
                            'badge-warning';
                        document.getElementById('detail-pembayaran').innerHTML = `<span class="badge ${paymentBadgeClass}">${data.data.status_pembayaran}</span>`;

                        document.getElementById('detail-total').textContent = data.data.total_pembayaran === '-' ?
                            '-' : `Rp${data.data.total_pembayaran}`;

                        // Tampilkan bukti pembayaran atau tanda strip jika tidak ada
                        if (data.data.bukti_pembayaran) {
                            document.getElementById('detail-bukti-text').style.display = 'none';
                            const buktiUrl = `/storage/bukti_pembayaran/${data.data.bukti_pembayaran}`;
                            document.getElementById('detail-bukti').src = buktiUrl;
                            document.getElementById('detail-bukti').style.display = 'block';
                            document.getElementById('detail-bukti').onerror = function() {
                                this.style.display = 'none';
                                document.getElementById('detail-bukti-text').style.display = 'block';
                                document.getElementById('detail-bukti-text').textContent = 'Gambar tidak dapat dimuat';
                            };
                        } else {
                            document.getElementById('detail-bukti-text').style.display = 'block';
                            document.getElementById('detail-bukti').style.display = 'none';
                            document.getElementById('detail-bukti-text').textContent = 'Belum ada bukti pembayaran';
                        }
                    } else {
                        alert('Gagal mengambil detail pemesanan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil detail pemesanan');
                });
        }

        function confirmPayment(idPembayaran) {
            if (confirm('Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?')) {
                fetch(`/admin/transactions/${idPembayaran}/confirm`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Pembayaran berhasil dikonfirmasi');
                            location.reload();
                        } else {
                            alert(data.message || 'Gagal mengkonfirmasi pembayaran');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengkonfirmasi pembayaran');
                    });
            }
        }

        function showConfirmation(kodeTransaksi) {
            const modal = document.getElementById('confirmModal');
            document.getElementById('confirmReservationId').textContent = kodeTransaksi;
            window.reservationToConfirm = kodeTransaksi;
            modal.showModal();
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').close();
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

        // Fungsi untuk memperbarui status pemesanan di tabel
        function updateReservationStatus(kodeTransaksi, newStatus) {
            const rows = document.querySelectorAll('.reservation-table tbody tr');
            rows.forEach(row => {
                const kodeTrx = row.cells[0].textContent;
                if (kodeTrx === kodeTransaksi) {
                    // Update badge status
                    const statusCell = row.cells[6];
                    const badgeClass =
                        newStatus === 'selesai' ? 'badge-info' :
                        newStatus === 'dibatalkan' ? 'badge-error' :
                        newStatus === 'dikonfirmasi' ? 'badge-success' :
                        'badge-warning';

                    statusCell.innerHTML = `<span class="badge ${badgeClass}">${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}</span>`;

                    // Sembunyikan tombol aksi jika status bukan menunggu
                    if (newStatus !== 'menunggu') {
                        const actionCell = row.cells[7];
                        const actionButtons = actionCell.querySelectorAll('button');
                        actionButtons.forEach((btn, index) => {
                            if (index > 0) btn.remove(); // Hapus tombol konfirmasi dan batal, sisakan tombol detail
                        });
                    }
                }
            });
        }

        function confirmReservation() {
            const kodeTransaksi = window.reservationToConfirm;

            // Kirim request ke endpoint konfirmasi
            fetch(`/admin/pemesanan/${kodeTransaksi}/konfirmasi`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update status di tabel
                        updateReservationStatus(kodeTransaksi, 'dikonfirmasi');

                        // Tampilkan notifikasi sukses
                        showNotification('Pemesanan berhasil dikonfirmasi', 'alert-success');
                    } else {
                        showNotification(data.message || 'Gagal mengkonfirmasi pemesanan', 'alert-error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan saat mengkonfirmasi pemesanan', 'alert-error');
                });

            // Tutup modal
            closeConfirmModal();
        }

        function showCancellation(kodeTransaksi) {
            const modal = document.getElementById('cancelModal');
            document.getElementById('cancelReservationId').textContent = kodeTransaksi;
            window.reservationToCancel = kodeTransaksi;
            modal.showModal();
        }

        function closeCancelModal() {
            document.getElementById('cancelModal').close();
        }

        function cancelReservation() {
            const kodeTransaksi = window.reservationToCancel;

            // Kirim request ke endpoint pembatalan
            fetch(`/admin/pemesanan/${kodeTransaksi}/batalkan`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update status di tabel
                        updateReservationStatus(kodeTransaksi, 'dibatalkan');

                        // Tampilkan notifikasi sukses
                        showNotification('Pemesanan berhasil dibatalkan', 'alert-success');
                    } else {
                        showNotification(data.message || 'Gagal membatalkan pemesanan', 'alert-error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan saat membatalkan pemesanan', 'alert-error');
                });

            // Tutup modal
            closeCancelModal();
        }
    </script>
</body>

</html>