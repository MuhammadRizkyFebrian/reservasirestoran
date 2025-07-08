@extends('staf.layouts.staf2')

@section('title', 'Data Pemesanan')

@section('page_title', 'Data Pemesanan')

@section('additional_styles')
.reservation-table {
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
color: #FFA500;
}

.status-confirmed {
background-color: rgba(0, 200, 0, 0.15);
color: #00C800;
}

.status-completed {
background-color: rgba(0, 100, 200, 0.15);
color: #0064C8;
}

.status-cancelled {
background-color: rgba(200, 0, 0, 0.15);
color: #C80000;
}

@media (max-width: 1024px) {
.reservation-table {
display: block;
overflow-x: auto;
}
}

@media (max-width: 480px) {
.reservation-table th,
.reservation-table td {
padding: 0.5rem;
font-size: 0.85rem;
}
}
@endsection

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold mb-6 flex items-center">
        <i class='bx bx-calendar mr-2 text-primary'></i>
        Daftar Pemesanan
    </h2>

    <!-- Search & Filter Form -->
    <div class="search-form">
        <input type="text" placeholder="Cari pemesanan..." class="input input-bordered" id="searchInput">
        <div class="flex gap-2">
            <select class="select select-bordered" id="statusFilter">
                <option value="">Semua Status</option>
                <option value="menunggu">Menunggu</option>
                <option value="dikonfirmasi">Dikonfirmasi</option>
                <option value="selesai">Selesai</option>
                <option value="dibatalkan">Dibatalkan</option>
            </select>
            <button class="btn btn-primary text-white" onclick="filterTable()">
                <i class='bx bx-search mr-1'></i>
                <span>Cari</span>
            </button>
        </div>
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
@endsection

@section('modals')
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
@endsection

@section('scripts')
// Function to show detail
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

// Function to show confirmation modal
function showConfirmation(kodeTransaksi) {
const modal = document.getElementById('confirmModal');
document.getElementById('confirmReservationId').textContent = kodeTransaksi;
window.reservationToConfirm = kodeTransaksi;
modal.showModal();
}

function closeConfirmModal() {
document.getElementById('confirmModal').close();
}

// Function to show cancellation modal
function showCancellation(kodeTransaksi) {
const modal = document.getElementById('cancelModal');
document.getElementById('cancelReservationId').textContent = kodeTransaksi;
window.reservationToCancel = kodeTransaksi;
modal.showModal();
}

function closeCancelModal() {
document.getElementById('cancelModal').close();
}

// Function to show notification
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

// Function to update reservation status in table
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

// Function to confirm reservation
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

// Function to cancel reservation
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

// Search and filter functionality
function filterTable() {
const searchText = document.getElementById('searchInput').value.toLowerCase();
const statusValue = document.getElementById('statusFilter').value.toLowerCase();
const rows = document.querySelectorAll('.reservation-table tbody tr');

rows.forEach(row => {
if (row.cells.length === 1) return; // Skip row "Tidak ada data pemesanan"

const kodeTransaksi = row.cells[0].textContent.toLowerCase();
const namaPemesan = row.cells[1].textContent.toLowerCase();
const nomorMeja = row.cells[2].textContent.toLowerCase();
const jumlahTamu = row.cells[3].textContent.toLowerCase();
const noHandphone = row.cells[4].textContent.toLowerCase();
const jadwal = row.cells[5].textContent.toLowerCase();
const statusBadge = row.cells[6].querySelector('.badge');
const status = statusBadge ? statusBadge.textContent.toLowerCase().trim() : '';

const matchesSearch = kodeTransaksi.includes(searchText) ||
namaPemesan.includes(searchText) ||
nomorMeja.includes(searchText) ||
jumlahTamu.includes(searchText) ||
noHandphone.includes(searchText) ||
jadwal.includes(searchText);

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
@endsection