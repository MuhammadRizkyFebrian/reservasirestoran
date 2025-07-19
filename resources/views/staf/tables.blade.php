@extends('staf.layouts.staf2')

@section('title', 'Data Meja')

@section('page_title', 'Data Meja')

@section('additional_styles')
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

/* Button tambah meja */
.add-table-btn {
transition: all 0.3s ease;
}

.add-table-btn:hover {
transform: translateY(-2px);
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
@endsection

@section('content')
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
        <button class="btn btn-primary add-table-btn text-white" onclick="openAddModal()">
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
            <button type="button" class="btn btn-primary text-white" onclick="filterTable()">
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
@endsection

@section('modals')
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
                <button type="submit" class="btn btn-primary text-white" id="saveButton">Simpan</button>
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
@endsection

@section('scripts')
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
noMeja: noMeja,
tipeMeja: tipeMeja,
harga: harga,
status: status,
kapasitas: kapasitas,
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

fetch('{{ route("staf.tables.delete") }}', {
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
tableData: tableData,
isNewData: isNewData,
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
    <button onclick="showSchedule('${tableData.no_meja}')"
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
<button onclick="showSchedule('${tableData.no_meja}')"
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

// Handle form submission
document.getElementById('tableForm').addEventListener('submit', function(e) {
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
'{{ route("staf.tables.update") }}' :
'{{ route("staf.tables.create") }}';

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
const statusFilter = document.getElementById('statusFilter');

function filterTable() {
const searchText = searchInput.value.toLowerCase();
const statusValue = statusFilter.value.toLowerCase();
const rows = document.querySelectorAll('.table-data-table tbody tr');

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

async function showSchedule(noMeja) {
try {
const response = await fetch(`/staf/meja/${noMeja}/schedule`);
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
@endsection