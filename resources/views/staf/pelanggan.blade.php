@extends('staf.layouts.staf2')

@section('title', 'Data Pelanggan')

@section('page_title', 'Data Pelanggan')

@section('additional_styles')
.customer-table {
width: 100%;
border-collapse: separate;
border-spacing: 0;
overflow: hidden;
border-radius: 0.75rem;
box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}

.customer-table th {
background-color: var(--fallback-base-200, oklch(var(--b2)));
padding: 1rem;
text-align: left;
font-weight: 600;
text-transform: uppercase;
font-size: 0.75rem;
letter-spacing: 0.05em;
}

.customer-table td {
padding: 1rem;
border-bottom: 1px solid var(--fallback-base-300, oklch(var(--b3)/0.1));
}

.customer-table tr:last-child td {
border-bottom: none;
}

.customer-table tr {
transition: all 0.3s ease;
}

.customer-table tr:hover {
background-color: var(--fallback-base-300, oklch(var(--b3)/0.1));
}

.customer-table td .action-buttons {
display: flex;
gap: 0.5rem;
}

.action-edit-btn,
.action-delete-btn {
transition: all 0.3s ease;
}

.action-edit-btn:hover,
.action-delete-btn:hover {
transform: translateY(-2px);
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

@media (max-width: 1024px) {
.customer-table {
display: block;
overflow-x: auto;
}
}

@media (max-width: 480px) {
.customer-table th,
.customer-table td {
padding: 0.5rem;
font-size: 0.85rem;
}
}
@endsection

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold mb-6 flex items-center">
        <i class='bx bxs-user-detail mr-2 text-primary'></i>
        Daftar Pelanggan
    </h2>

    <!-- Search & Filter Form -->
    <div class="search-form">
        <input type="text" placeholder="Cari pelanggan..." class="input input-bordered" id="searchInput">
        <button class="btn btn-primary text-white">
            <i class='bx bx-search mr-1'></i>
            <span>Cari</span>
        </button>
    </div>

    <!-- Customer Table -->
    <div class="overflow-x-auto">
        <table class="customer-table bg-base-100">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>No. Handphone</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pelanggan as $index => $customer)
                <tr>
                    <td>{{ ($pelanggan->currentPage() - 1) * $pelanggan->perPage() + $index + 1 }}</td>
                    <td>{{ $customer->username }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->nomor_handphone }}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-primary action-edit-btn"
                                onclick="openEditModal('{{ $customer->id_pelanggan }}', '{{ $customer->email }}', '{{ $customer->username }}', '{{ $customer->nomor_handphone }}')">
                                <i class='bx bx-edit-alt'></i>
                                <span class="hidden sm:inline ml-1">Edit</span>
                            </button>
                            <button class="btn btn-sm btn-error action-delete-btn"
                                onclick="confirmDelete('{{ $customer->id_pelanggan }}')">
                                <i class='bx bx-trash'></i>
                                <span class="hidden sm:inline ml-1">Hapus</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">
                        Tidak ada data pelanggan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <div class="text-sm text-base-content/70">
            Menampilkan {{ $pelanggan->firstItem() }}-{{ $pelanggan->lastItem() }} dari {{ $pelanggan->total() }}
            pelanggan
        </div>
        <div class="pagination-buttons">
            @if ($pelanggan->onFirstPage())
            <button class="btn btn-sm btn-outline pagination-button" disabled>
                <i class='bx bx-chevron-left'></i>
                <span>Sebelumnya</span>
            </button>
            @else
            <a href="{{ $pelanggan->previousPageUrl() }}" class="btn btn-sm btn-outline pagination-button">
                <i class='bx bx-chevron-left'></i>
                <span>Sebelumnya</span>
            </a>
            @endif

            @if ($pelanggan->hasMorePages())
            <a href="{{ $pelanggan->nextPageUrl() }}" class="btn btn-sm btn-outline pagination-button">
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
<!-- Edit Customer Modal -->
<dialog id="editCustomerModal" class="modal">
    <div class="modal-box max-w-md">
        <h3 class="font-bold text-lg mb-4">Edit Data Pelanggan</h3>
        <form id="editCustomerForm" class="space-y-4">
            <input type="hidden" id="customerId">

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" id="customerEmail" class="input input-bordered" required>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Username</span>
                </label>
                <input type="text" id="customerUsername" class="input input-bordered" required>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">No. Handphone</span>
                </label>
                <input type="tel" id="customerPhone" class="input input-bordered" required>
            </div>

            <div class="modal-action">
                <button type="button" class="btn btn-outline" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary text-white">Simpan Perubahan</button>
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
        <h3 class="font-bold text-lg mb-4">Konfirmasi Hapus Pelanggan</h3>
        <p>Apakah Anda yakin ingin menghapus pelanggan ini?</p>
        <p class="text-error text-sm mt-2">Tindakan ini tidak dapat dibatalkan.</p>
        <div class="modal-action">
            <button class="btn btn-outline" onclick="closeDeleteModal()">Batal</button>
            <button class="btn btn-error" onclick="deleteCustomer()">Hapus</button>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
@endsection

@section('scripts')
// Handle edit form submission
document.getElementById('editCustomerForm').addEventListener('submit', function(e) {
e.preventDefault();

const customerId = document.getElementById('customerId').value;
const email = document.getElementById('customerEmail').value;
const username = document.getElementById('customerUsername').value;
const phone = document.getElementById('customerPhone').value;

// Kirim request ke server
fetch('{{ route("staf.customers.update") }}', {
method: 'POST',
headers: {
'Content-Type': 'application/json',
'X-CSRF-TOKEN': '{{ csrf_token() }}'
},
body: JSON.stringify({
id_pelanggan: customerId,
email: email,
username: username,
nomor_handphone: phone
})
})
.then(response => response.json())
.then(data => {
if (data.message) {
alert(data.message);
if (data.message.includes('berhasil')) {
window.location.reload();
}
}
})
.catch(error => {
console.error('Error:', error);
alert('Terjadi kesalahan saat memperbarui data pelanggan');
});

// Close the modal
document.getElementById('editCustomerModal').close();
});

// Function to open edit modal
function openEditModal(id, email, username, phone) {
const modal = document.getElementById('editCustomerModal');
document.getElementById('customerId').value = id;
document.getElementById('customerEmail').value = email;
document.getElementById('customerUsername').value = username;
document.getElementById('customerPhone').value = phone;
modal.showModal();
}

// Function to close edit modal
function closeEditModal() {
document.getElementById('editCustomerModal').close();
}

// Function to open delete confirmation modal
function confirmDelete(id) {
const modal = document.getElementById('deleteConfirmModal');
window.customerToDelete = id;
modal.showModal();
}

// Function to delete customer
function deleteCustomer() {
const customerId = window.customerToDelete;

fetch('{{ route("staf.customers.delete") }}', {
method: 'POST',
headers: {
'Content-Type': 'application/json',
'X-CSRF-TOKEN': '{{ csrf_token() }}'
},
body: JSON.stringify({
id_pelanggan: customerId,
_token: '{{ csrf_token() }}'
})
})
.then(response => {
if (!response.ok) {
return response.json().then(data => {
throw new Error(data.message || 'Terjadi kesalahan saat menghapus pelanggan');
});
}
return response.json();
})
.then(data => {
window.location.reload();
})
.catch(error => {
console.error('Error:', error);
alert(error.message);
});

closeDeleteModal();
}

// Function to close delete modal
function closeDeleteModal() {
document.getElementById('deleteConfirmModal').close();
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
const searchText = this.value.toLowerCase();
const rows = document.querySelectorAll('.customer-table tbody tr');

rows.forEach(row => {
const email = row.cells[1].textContent.toLowerCase();
const username = row.cells[2].textContent.toLowerCase();
const phone = row.cells[3].textContent.toLowerCase();

if (email.includes(searchText) || username.includes(searchText) || phone.includes(searchText)) {
row.style.display = '';
} else {
row.style.display = 'none';
}
});
});
@endsection