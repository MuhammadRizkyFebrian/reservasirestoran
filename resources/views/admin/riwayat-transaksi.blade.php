<!DOCTYPE html>
<html lang="id" data-theme="lemonade">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Selesai - Seatify</title>

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

        .transaction-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 0.75rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .transaction-table th {
            background-color: var(--fallback-base-200, oklch(var(--b2)));
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .transaction-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--fallback-base-300, oklch(var(--b3)/0.1));
        }

        .transaction-table tr:last-child td {
            border-bottom: none;
        }

        .transaction-table tr {
            transition: all 0.3s ease;
        }

        .transaction-table tr:hover {
            background-color: var(--fallback-base-300, oklch(var(--b3)/0.1));
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
            background-color: rgba(0, 200, 0, 0.15);
            /* Green */
            color: #00C800;
        }

        .status-completed {
            background-color: rgba(0, 100, 200, 0.15);
            /* Blue */
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

            .transaction-table th,
            .transaction-table td {
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

            <a href="{{ route('admin.pemesanan') }}" class="menu-item">
                <i class='bx bx-calendar-edit'></i>
                <span>Pemesanan</span>
            </a>

            <a href="{{ route('admin.transactions') }}" class="menu-item active">
                <i class='bx bx-history'></i>
                <span>Transaksi Selesai</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-wrapper" id="contentWrapper">
        <div class="header">
            <h1 class="text-3xl font-bold">Transaksi Selesai</h1>
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
                Transaksi Selesai
            </h2>

            <!-- Search & Filter Form -->
            <div class="search-form">
                <input type="text" placeholder="Cari transaksi selesai..." class="input input-bordered" id="searchInput">
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
                            <th>Kode Transaksi</th>
                            <th>No. Meja</th>
                            <th>Total Pembayaran</th>
                            <th>Metode Pembayaran</th>
                            <th>Status</th>
                            <th>Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->kode_transaksi }}</td>
                            <td>{{ str_replace(',', ', ', $transaction->nomor_meja) }}</td>
                            <td>Rp{{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                            <td>{{ strtoupper($transaction->metode_pembayaran) }}</td>
                            <td>
                                <span class="badge {{ 
                                    $transaction->status == 'dikonfirmasi' ? 'badge-success' : 
                                    ($transaction->status == 'selesai' ? 'badge-info' : 
                                    ($transaction->status == 'dibatalkan' ? 'badge-error' : 
                                    'badge-warning')) 
                                }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="viewPaymentProof('{{ $transaction->bukti_pembayaran }}')">
                                    <i class='bx bx-show-alt'></i>
                                    <span class="hidden sm:inline ml-1">Detail</span>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                Tidak ada data transaksi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <div class="text-sm text-base-content/70">
                    Menampilkan {{ $transactions->firstItem() ?? 0 }}-{{ $transactions->lastItem() ?? 0 }} dari {{ $transactions->total() ?? 0 }} transaksi selesai
                </div>
                <div class="pagination-buttons">
                    @if ($transactions->onFirstPage())
                    <button class="btn btn-sm btn-outline pagination-button" disabled>
                        <i class='bx bx-chevron-left'></i>
                        <span>Sebelumnya</span>
                    </button>
                    @else
                    <a href="{{ $transactions->previousPageUrl() }}" class="btn btn-sm btn-outline pagination-button">
                        <i class='bx bx-chevron-left'></i>
                        <span>Sebelumnya</span>
                    </a>
                    @endif

                    @if ($transactions->hasMorePages())
                    <a href="{{ $transactions->nextPageUrl() }}" class="btn btn-sm btn-outline pagination-button">
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

    <!-- Transaction Detail Modal -->
    <dialog id="transactionDetailModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Detail Transaksi</h3>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-base-content/70">ID Transaksi</p>
                        <p class="font-semibold" id="detailTransactionId"></p>
                    </div>
                    <div>
                        <p class="text-sm text-base-content/70">Status</p>
                        <div id="detailStatus"></div>
                    </div>
                    <div>
                        <p class="text-sm text-base-content/70">Nama Pemesan</p>
                        <p class="font-semibold" id="detailCustomerName"></p>
                    </div>
                    <div>
                        <p class="text-sm text-base-content/70">Total Pembayaran</p>
                        <p class="font-semibold" id="detailAmount"></p>
                    </div>
                    <div>
                        <p class="text-sm text-base-content/70">Metode Pembayaran</p>
                        <p class="font-semibold" id="detailPaymentMethod"></p>
                    </div>
                    <div>
                        <p class="text-sm text-base-content/70">Tanggal Pembayaran</p>
                        <p class="font-semibold" id="detailPaymentDate"></p>
                    </div>
                </div>

                <div>
                    <p class="text-sm text-base-content/70 mb-2">Bukti Pembayaran</p>
                    <img id="detailPaymentProof" src="" alt="Bukti Pembayaran" class="w-full max-w-sm mx-auto rounded-lg">
                </div>

                <div class="modal-action">
                    <button class="btn btn-ghost" onclick="closeTransactionDetail()">Tutup</button>
                    <button class="btn btn-primary" onclick="confirmPayment()">Konfirmasi Pembayaran</button>
                </div>
            </div>
        </div>
    </dialog>

    <!-- Payment Proof Modal -->
    <dialog id="paymentProofModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Bukti Pembayaran</h3>
            <div class="w-full">
                <img id="paymentProofImage" src="" alt="Bukti Pembayaran" class="w-full rounded-lg">
            </div>
            <div class="modal-action">
                <button class="btn btn-ghost" onclick="closePaymentProof()">Tutup</button>
            </div>
        </div>
    </dialog>

    <!-- Edit Transaction Modal -->
    <dialog id="editTransactionModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Edit Transaksi</h3>
            <form id="editTransactionForm" class="space-y-4">
                @csrf
                <div>
                    <label class="label">Status</label>
                    <select name="status" class="select select-bordered w-full">
                        <option value="menunggu">Menunggu</option>
                        <option value="dikonfirmasi">Dikonfirmasi</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                <div>
                    <label class="label">Total Pembayaran</label>
                    <input type="number" name="total_harga" class="input input-bordered w-full" required>
                </div>
                <div>
                    <label class="label">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="select select-bordered w-full">
                        <option value="bca">BCA</option>
                        <option value="bni">BNI</option>
                        <option value="bri">BRI</option>
                        <option value="mandiri">Mandiri</option>
                    </select>
                </div>
                <div class="modal-action">
                    <button type="button" class="btn btn-ghost" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
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
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchText) ? '' : 'none';
                });
            });
        });

        let currentTransactionId = null;

        function viewTransactionDetails(id) {
            currentTransactionId = id;
            const modal = document.getElementById('transactionDetailModal');

            // Fetch transaction details
            fetch(`/admin/transactions/${id}`)
                .then(response => response.json())
                .then(response => {
                    if (!response.success) {
                        throw new Error(response.message);
                    }
                    const data = response.data;
                    document.getElementById('detailTransactionId').textContent = `#${data.id_pembayaran}`;
                    document.getElementById('detailCustomerName').textContent = data.nama_pemesan;
                    document.getElementById('detailAmount').textContent = `Rp${new Intl.NumberFormat('id-ID').format(data.total_harga)}`;
                    document.getElementById('detailPaymentMethod').textContent = data.metode_pembayaran.toUpperCase();
                    document.getElementById('detailPaymentDate').textContent = new Date(data.created_at).toLocaleDateString('id-ID');

                    // Set status with appropriate styling
                    const statusClass = data.status === 'menunggu' ? 'status-pending' :
                        (data.status === 'dikonfirmasi' ? 'status-completed' : 'status-cancelled');
                    document.getElementById('detailStatus').innerHTML = `
                        <span class="table-status ${statusClass}">
                            <i class='bx bxs-circle mr-1 text-xs'></i>
                            ${data.status.charAt(0).toUpperCase() + data.status.slice(1)}
                        </span>
                    `;

                    // Set bukti pembayaran image
                    document.getElementById('detailPaymentProof').src = `/storage/bukti_pembayaran/${data.bukti_pembayaran}`;

                    modal.showModal();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'Terjadi kesalahan saat mengambil detail transaksi');
                });
        }

        function closeTransactionDetail() {
            document.getElementById('transactionDetailModal').close();
        }

        function confirmPayment() {
            if (!currentTransactionId) return;

            if (!confirm('Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?')) return;

            fetch(`/admin/transactions/${currentTransactionId}/confirm`, {
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
                        window.location.reload();
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'Terjadi kesalahan saat mengkonfirmasi pembayaran');
                });
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('.transaction-table tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });

        function viewPaymentProof(filename) {
            if (!filename) {
                alert('Bukti pembayaran tidak tersedia');
                return;
            }
            const modal = document.getElementById('paymentProofModal');
            document.getElementById('paymentProofImage').src = `/storage/bukti_pembayaran/${filename}`;
            modal.showModal();
        }

        function closePaymentProof() {
            document.getElementById('paymentProofModal').close();
        }

        function editTransaction(id) {
            currentTransactionId = id;
            const modal = document.getElementById('editTransactionModal');

            // Fetch transaction data
            fetch(`/admin/transactions/${id}`)
                .then(response => response.json())
                .then(response => {
                    if (!response.success) {
                        throw new Error(response.message);
                    }
                    const data = response.data;
                    const form = document.getElementById('editTransactionForm');
                    form.querySelector('[name="status"]').value = data.status;
                    form.querySelector('[name="total_harga"]').value = data.total_harga;
                    form.querySelector('[name="metode_pembayaran"]').value = data.metode_pembayaran;
                    modal.showModal();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'Terjadi kesalahan saat mengambil data transaksi');
                });
        }

        function closeEditModal() {
            document.getElementById('editTransactionModal').close();
        }

        document.getElementById('editTransactionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            if (!currentTransactionId) return;

            const formData = new FormData(this);
            fetch(`/admin/transactions/${currentTransactionId}/update`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Transaksi berhasil diperbarui');
                        window.location.reload();
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'Terjadi kesalahan saat memperbarui transaksi');
                });
        });
    </script>
</body>

</html>