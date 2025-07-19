@extends('staf.layouts.staf')

@section('title', 'Data Menu')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="mb-8">
    <!-- Notifikasi -->
    <div id="notification" class="toast toast-end hidden">
        <div class="alert shadow-lg">
            <i class='bx bx-check-circle'></i>
            <span id="notificationMessage"></span>
        </div>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold flex items-center">
            <i class='bx bx-food-menu mr-2 text-primary'></i>
            Daftar Menu
        </h2>
        <!-- Trigger Modal -->
        <label for="modalTambah" class="btn btn-primary text-white">
            <i class='bx bx-plus mr-1'></i>
            Tambah Menu
        </label>
    </div>

    <!-- Alert Berhasil/Gagal -->
    @if(session('success'))
    <div role="alert" class="alert alert-success shadow-lg mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ session('success') }}</span>
        <button class="btn btn-sm btn-circle btn-ghost ml-auto" onclick="this.parentElement.style.display='none'">×</button>
    </div>
    @endif

    @if(session('error'))
    <div role="alert" class="alert alert-error shadow-lg mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <span>{{ session('error') }}</span>
        <button class="btn btn-sm btn-circle btn-ghost ml-auto" onclick="this.parentElement.style.display='none'">×</button>
    </div>
    @endif

    <!-- Search Form -->
    <div class="search-form">
        <input type="text" placeholder="Cari menu..." class="input input-bordered" id="searchInput">
        <div class="flex gap-2">
            <select class="select select-bordered" id="typeFilter">
                <option value="">Semua Tipe</option>
                <option value="makanan">Makanan</option>
                <option value="minuman">Minuman</option>
            </select>
            <button type="button" class="btn btn-primary text-white" onclick="filterTable()">
                <i class='bx bx-search'></i>
                Cari
            </button>
        </div>
    </div>

    <!-- Tabel Menu -->
    <div class="overflow-x-hidden">
        <table class="table-data-table bg-base-100">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Menu</th>
                    <th>Gambar</th>
                    <th>Kategori</th>
                    <th>Tipe</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($menus as $index => $menu)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $menu->nama }}</td>
                    <td>
                        <img src="{{ $menu->gambar ? asset('storage/menu/' . $menu->gambar) : asset('images/placeholder.jpg') }}"
                            alt="{{ $menu->nama }}"
                            class="w-16 h-16 object-cover rounded" />
                    </td>
                    <td>{{ $menu->kategori }}</td>
                    <td>{{ ucfirst($menu->tipe) }}</td>
                    <td>
                        <button onclick="document.getElementById('modal-desc-{{ $menu->id_menu }}').showModal()" class="btn btn-xs btn-info">
                            <i class='bx bx-info-circle mr-1'></i>
                            Lihat
                        </button>

                        <dialog id="modal-desc-{{ $menu->id_menu }}" class="modal">
                            <div class="modal-box">
                                <h3 class="font-bold text-lg mb-2">Deskripsi Menu: {{ $menu->nama }}</h3>
                                <p class="mb-4">{{ $menu->deskripsi }}</p>
                                <div class="modal-action">
                                    <form method="dialog">
                                        <button class="btn">Tutup</button>
                                    </form>
                                </div>
                            </div>
                        </dialog>
                    </td>
                    <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                    <td>
                        <div class="action-buttons">
                            <button type="button" data-menu-id="{{ $menu->id_menu }}" class="btn btn-sm btn-primary action-edit-btn">
                                <i class='bx bx-edit-alt'></i>
                                <span class="hidden sm:inline ml-1">Edit</span>
                            </button>
                            <button type="button" data-menu-id="{{ $menu->id_menu }}" class="btn btn-sm btn-error delete-menu-btn">
                                <i class='bx bx-trash'></i>
                                <span class="hidden sm:inline ml-1">Hapus</span>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <dialog id="modal-edit-{{ $menu->id_menu }}" class="modal">
                    <div class="modal-box max-w-3xl">
                        <h3 class="font-bold text-lg mb-4">Edit Menu: {{ $menu->nama }}</h3>
                        <form action="{{ route('menus.update', $menu->id_menu) }}" method="POST" class="edit-form" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label" for="nama-{{ $menu->id_menu }}">Nama Menu</label>
                                    <input type="text" name="nama" id="nama-{{ $menu->id_menu }}" class="input input-bordered" value="{{ old('nama', $menu->nama) }}" required>
                                </div>

                                <div class="form-control">
                                    <label class="label" for="kategori-{{ $menu->id_menu }}">Kategori</label>
                                    <input type="text" name="kategori" id="kategori-{{ $menu->id_menu }}" class="input input-bordered" value="{{ old('kategori', $menu->kategori) }}" required>
                                </div>

                                <div class="form-control">
                                    <label class="label" for="tipe-{{ $menu->id_menu }}">Tipe</label>
                                    <select name="tipe" id="tipe-{{ $menu->id_menu }}" class="select select-bordered" required>
                                        <option value="makanan" {{ old('tipe', $menu->tipe) == 'makanan' ? 'selected' : '' }}>Makanan</option>
                                        <option value="minuman" {{ old('tipe', $menu->tipe) == 'minuman' ? 'selected' : '' }}>Minuman</option>
                                    </select>
                                </div>

                                <div class="form-control">
                                    <label class="label" for="harga-{{ $menu->id_menu }}">Harga</label>
                                    <input type="number" name="harga" id="harga-{{ $menu->id_menu }}" class="input input-bordered" value="{{ old('harga', $menu->harga) }}" required>
                                </div>

                                <div class="form-control md:col-span-2">
                                    <label class="label" for="deskripsi-{{ $menu->id_menu }}">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi-{{ $menu->id_menu }}" class="textarea textarea-bordered" rows="3" required>{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                                </div>

                                <div class="form-control md:col-span-2">
                                    <label class="label" for="gambar-{{ $menu->id_menu }}">Ganti Gambar</label>
                                    <input type="file" name="gambar" id="gambar-{{ $menu->id_menu }}" class="file-input file-input-bordered">
                                    <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti gambar</p>
                                </div>
                            </div>

                            <div class="modal-action mt-4 flex justify-between">
                                <button type="button" class="btn" onclick="document.getElementById('modal-edit-{{ $menu->id_menu }}').close()">Batal</button>
                                <button type="submit" class="btn btn-primary text-white">Simpan</button>
                            </div>
                        </form>
                    </div>
                </dialog>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        Tidak ada data menu
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <div class="text-sm text-base-content/70">
                Menampilkan {{ $menus->firstItem() }}-{{ $menus->lastItem() }} dari {{ $menus->total() }} menu
            </div>
            <div class="pagination-buttons">
                @if ($menus->onFirstPage())
                <button class="btn btn-sm btn-outline pagination-button" disabled>
                    <i class='bx bx-chevron-left'></i>
                    <span>Sebelumnya</span>
                </button>
                @else
                <a href="{{ $menus->previousPageUrl() }}" class="btn btn-sm btn-outline pagination-button">
                    <i class='bx bx-chevron-left'></i>
                    <span>Sebelumnya</span>
                </a>
                @endif

                @if ($menus->hasMorePages())
                <a href="{{ $menus->nextPageUrl() }}" class="btn btn-sm btn-outline pagination-button">
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

<!-- Modal Tambah Menu -->
<dialog id="modalTambah" class="modal">
    <div class="modal-box max-w-3xl">
        <h3 class="font-bold text-lg mb-4">Tambah Menu Baru</h3>
        <form action="{{ route('menus.store') }}" method="POST" class="add-form" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label" for="nama">Nama Menu</label>
                    <input type="text" name="nama" id="nama" class="input input-bordered" required>
                </div>

                <div class="form-control">
                    <label class="label" for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="input input-bordered" required>
                </div>

                <div class="form-control">
                    <label class="label" for="tipe">Tipe</label>
                    <select name="tipe" id="tipe" class="select select-bordered" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label" for="harga">Harga</label>
                    <input type="number" name="harga" id="harga" class="input input-bordered" required>
                </div>

                <div class="form-control md:col-span-2">
                    <label class="label" for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="textarea textarea-bordered" rows="3" required></textarea>
                </div>

                <div class="form-control md:col-span-2">
                    <label class="label" for="gambar">Gambar</label>
                    <input type="file" name="gambar" id="gambar" class="file-input file-input-bordered" required>
                </div>
            </div>

            <div class="modal-action">
                <button type="button" class="btn" onclick="document.getElementById('modalTambah').close()">Batal</button>
                <button type="submit" class="btn btn-primary text-white">Simpan</button>
            </div>
        </form>
    </div>
</dialog>

<!-- Modal Konfirmasi Hapus -->
<dialog id="modalDelete" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Konfirmasi Hapus</h3>
        <p>Apakah anda yakin ingin menghapus menu ini? Proses ini tidak dapat dibatalkan.</p>
        <form method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="modal-action">
                <button type="button" class="btn" onclick="document.getElementById('modalDelete').close()">Batal</button>
                <button type="submit" class="btn btn-error">Hapus</button>
            </div>
        </form>
    </div>
</dialog>

<!-- Theme Switcher -->
<div class="theme-switcher dropdown dropdown-right dropdown-end hidden">
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
        const searchInput = document.getElementById('searchInput');
        const typeFilter = document.getElementById('typeFilter');
        const rows = document.querySelectorAll('.table-data-table tbody tr');

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            const typeValue = typeFilter.value.toLowerCase();

            rows.forEach(row => {
                const nama = row.cells[1].textContent.toLowerCase();
                const kategori = row.cells[3].textContent.toLowerCase();
                const tipe = row.cells[4].textContent.toLowerCase();

                const matchesSearch = nama.includes(searchText) || kategori.includes(searchText);
                const matchesType = typeValue === '' || tipe.includes(typeValue);

                if (matchesSearch && matchesType) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterTable);
        typeFilter.addEventListener('change', filterTable);

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

        // Handle edit button clicks
        document.querySelectorAll('.action-edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const menuId = this.dataset.menuId;
                const modal = document.getElementById(`modal-edit-${menuId}`);
                if (modal) modal.showModal();
            });
        });

        // Handle edit form submissions
        document.querySelectorAll('.edit-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const modal = this.closest('.modal');

                fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (response.ok) {
                            showNotification('Menu berhasil diupdate', 'alert-success');
                            if (modal) modal.close();
                            setTimeout(() => window.location.reload(), 2000);
                        } else {
                            throw new Error('Gagal mengupdate menu');
                        }
                    })
                    .catch(error => {
                        showNotification(error.message, 'alert-error');
                    });
            });
        });

        // Handle delete button clicks
        document.querySelectorAll('.delete-menu-btn').forEach(button => {
            button.addEventListener('click', function() {
                const menuId = this.dataset.menuId;
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = '{{ url("/staf/menus") }}/' + menuId;
                document.getElementById('modalDelete').showModal();
            });
        });

        // Handle delete form submission
        document.getElementById('deleteForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const modal = this.closest('.modal');
            const token = document.querySelector('input[name="_token"]').value;

            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        _method: 'DELETE',
                        _token: token
                    })
                })
                .then(response => {
                    if (response.ok) {
                        showNotification('Menu berhasil dihapus', 'alert-success');
                        if (modal) modal.close();
                        setTimeout(() => window.location.reload(), 2000);
                    } else {
                        throw new Error('Gagal menghapus menu');
                    }
                })
                .catch(error => {
                    showNotification(error.message, 'alert-error');
                });
        });

        // Handle add form submission
        document.querySelector('.add-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const modal = this.closest('.modal');

            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        showNotification('Menu berhasil ditambahkan', 'alert-success');
                        if (modal) modal.close();
                        setTimeout(() => window.location.reload(), 2000);
                    } else {
                        throw new Error('Gagal menambahkan menu');
                    }
                })
                .catch(error => {
                    showNotification(error.message, 'alert-error');
                });
        });

        // Function to open add modal
        function openAddModal() {
            const modal = document.getElementById('modalTambah');
            const form = modal.querySelector('.add-form');
            form.reset();
            modal.showModal();
        }

        // Trigger modal tambah
        document.querySelector('label[for="modalTambah"]').addEventListener('click', openAddModal);
    });
</script>
@endsection