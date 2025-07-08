@extends('staf.layouts.staf2')

@section('title', 'Transaksi Selesai')

@section('page_title', 'Transaksi Selesai')

@section('additional_styles')
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
color: #00C800;
}

.status-completed {
background-color: rgba(0, 100, 200, 0.15);
color: #0064C8;
}

/* Aksi */
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

@media (max-width: 768px) {
.search-form {
flex-direction: column;
align-items: flex-start;
}

.search-form input {
max-width: 100%;
width: 100%;
}
}
@endsection

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold mb-6 flex items-center">
        <i class='bx bx-history mr-2 text-primary'></i>
        Transaksi Selesai
    </h2>

    <!-- Search & Filter Form -->
    <div class="search-form">
        <input type="text" placeholder="Cari transaksi selesai..." class="input input-bordered" id="searchInput">
        <div class="flex gap-2">
            <select class="select select-bordered" id="statusFilter">
                <option value="">Semua Status</option>
                <option value="dikonfirmasi">Dikonfirmasi</option>
                <option value="selesai">Selesai</option>
            </select>
            <button class="btn btn-primary text-white" onclick="filterTable()">
                <i class='bx bx-search mr-1'></i>
                <span>Cari</span>
            </button>
        </div>
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
@endsection

@section('modals')
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
@endsection

@section('scripts')
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

// Search and filter functionality
function filterTable() {
const searchText = document.getElementById('searchInput').value.toLowerCase();
const statusValue = document.getElementById('statusFilter').value.toLowerCase();
const rows = document.querySelectorAll('.transaction-table tbody tr');

rows.forEach(row => {
if (row.cells.length === 1) return; // Skip row "Tidak ada data transaksi"

const kodeTransaksi = row.cells[0].textContent.toLowerCase();
const nomorMeja = row.cells[1].textContent.toLowerCase();
const totalPembayaran = row.cells[2].textContent.toLowerCase();
const metodePembayaran = row.cells[3].textContent.toLowerCase();
const statusBadge = row.cells[4].querySelector('.badge');
const status = statusBadge ? statusBadge.textContent.toLowerCase().trim() : '';

const matchesSearch = kodeTransaksi.includes(searchText) ||
nomorMeja.includes(searchText) ||
totalPembayaran.includes(searchText) ||
metodePembayaran.includes(searchText);

const matchesStatus = !statusValue || status === statusValue;

row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
});
}

// Tambahkan event listener untuk input pencarian dan filter status
document.addEventListener('DOMContentLoaded', function() {
const searchInput = document.getElementById('searchInput');
const statusFilter = document.getElementById('statusFilter');

if (searchInput) {
searchInput.addEventListener('input', filterTable);
}

if (statusFilter) {
statusFilter.addEventListener('change', filterTable);
}
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
@endsection