@extends('layouts.app', ['noFooter' => true])

@section('title', 'Profil Pengguna - ' . config('app.name'))

@section('styles')
.profile-sidebar {
    background-color: var(--fallback-b1,oklch(var(--b1)));
    border-radius: 1rem;
    padding: 2rem;
    height: 100%;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.profile-image {
    width: 140px;
    height: 140px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid var(--fallback-primary,oklch(var(--p)));
}

.edit-button {
    position: absolute;
    bottom: 0;
    right: 10px;
    background-color: var(--fallback-primary,oklch(var(--p)));
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.nav-item {
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    margin-bottom: 0.5rem;
    transition: all 0.2s ease;
    cursor: pointer;
    display: flex;
    align-items: center;
}

.nav-item:hover, .nav-item.active {
    background-color: var(--fallback-primary,oklch(var(--p)));
    color: var(--fallback-primary-content,oklch(var(--pc)));
}

.nav-item i {
    margin-right: 0.75rem;
    font-size: 1.2rem;
}

.profile-card {
    background-color: var(--fallback-b2,oklch(var(--b2)));
    border-radius: 0.75rem;
    padding: 1.25rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.06);
}

.edit-form-card {
    display: none;
}

.edit-form-card.active {
    display: block;
}

@media (max-width: 768px) {
    .profile-sidebar {
        margin-bottom: 2rem;
    }
}
@endsection

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Sidebar Profile -->
        <div class="md:col-span-1">
            <div class="profile-sidebar">
                <div class="flex flex-col items-center mb-6">
                    <div class="relative mb-4">
                        <img src="https://ui-avatars.com/api/?name=Rwfles&background=random&size=140" alt="Profile" id="profileAvatar" class="profile-image">
                        <label for="avatarUpload" class="edit-button">
                            <i class='bx bx-plus'></i>
                            <input type="file" id="avatarUpload" class="hidden" accept="image/*" />
                        </label>
                    </div>
                    <h2 class="text-xl font-bold mb-3">Rwfles</h2>
                    <div class="flex flex-col items-center space-y-2 text-center">
                        <div class="flex items-center">
                            <i class='bx bx-envelope text-base-content/70 mr-2'></i>
                            <span class="text-sm" id="displayEmail">Rwfles@gmail.com</span>
                        </div>
                        <div class="flex items-center">
                            <i class='bx bx-phone text-base-content/70 mr-2'></i>
                            <span class="text-sm" id="displayPhone">+62 812 3456 7890</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <a href="{{ route('profile') }}" class="nav-item active text-white">
                        <i class='bx bx-user'></i>
                        <span>Profil</span>
                    </a>
                    <a href="{{ route('reservation-history') }}" class="nav-item">
                        <i class='bx bx-history'></i>
                        <span>Riwayat Pemesanan</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-item w-full text-left">
                            <i class='bx bx-log-out'></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="md:col-span-3">
            <div class="flex justify-between items-center mb-3">
                <h1 class="text-xl sm:text-2xl font-bold">Informasi Akun</h1>
                <button id="editProfileBtn" class="btn btn-primary text-white btn-sm">
                    <i class='bx bx-edit mr-1'></i> Edit Profil
                </button>
            </div>
            
            <!-- View Card -->
            <div id="viewProfileCard" class="profile-card">
                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <p class="text-base-content/70 text-sm">Username</p>
                        <p class="font-medium" id="displayName">Rwfles</p>
                    </div>
                    <div>
                        <p class="text-base-content/70 text-sm">Email</p>
                        <p class="font-medium">Rwfles@gmail.com</p>
                    </div>
                    <div>
                        <p class="text-base-content/70 text-sm">Nomor Telepon</p>
                        <p class="font-medium">+62 812 3456 7890</p>
                    </div>
                </div>
            </div>
            
            <!-- Edit Card -->
            <div id="editProfileCard" class="profile-card edit-form-card">
                <form id="profileForm" class="space-y-3">
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text">Username</span>
                        </label>
                        <input type="text" id="inputName" class="input input-bordered input-sm" value="JohnDoe123" />
                    </div>
                    
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email" id="inputEmail" class="input input-bordered input-sm" value="johndoe@example.com" />
                    </div>
                    
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text">Nomor Telepon</span>
                        </label>
                        <input type="tel" id="inputPhone" class="input input-bordered input-sm" value="+62 812 3456 7890" />
                    </div>
                    
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" id="cancelEditBtn" class="btn btn-ghost btn-sm">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
            </div>
            
            <!-- Password Card -->
            <div class="profile-card">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-bold">Ubah Password</h2>
                </div>
                
                <form id="passwordForm" class="space-y-3">
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text">Password Lama</span>
                        </label>
                        <input type="password" id="currentPassword" class="input input-bordered input-sm" placeholder="Masukkan password lama" />
                    </div>
                    
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text">Password Baru</span>
                        </label>
                        <input type="password" id="newPassword" class="input input-bordered input-sm" placeholder="Masukkan password baru" />
                    </div>
                    
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text">Konfirmasi Password Baru</span>
                        </label>
                        <input type="password" id="confirmPassword" class="input input-bordered input-sm" placeholder="Konfirmasi password baru" />
                    </div>
                    
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="submit" class="btn btn-primary text-white btn-sm">Ubah Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const editProfileBtn = document.getElementById('editProfileBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const viewProfileCard = document.getElementById('viewProfileCard');
        const editProfileCard = document.getElementById('editProfileCard');
        const profileForm = document.getElementById('profileForm');
        const passwordForm = document.getElementById('passwordForm');
        const avatarUpload = document.getElementById('avatarUpload');
        const profileAvatar = document.getElementById('profileAvatar');
        
        // Display Fields
        const displayName = document.getElementById('displayName');
        const displayEmail = document.getElementById('displayEmail');
        const displayPhone = document.getElementById('displayPhone');
        
        // Input Fields
        const inputName = document.getElementById('inputName');
        const inputEmail = document.getElementById('inputEmail');
        const inputPhone = document.getElementById('inputPhone');
        
        // Show Edit Form
        editProfileBtn.addEventListener('click', function() {
            viewProfileCard.style.display = 'none';
            editProfileCard.classList.add('active');
        });
        
        // Cancel Edit
        cancelEditBtn.addEventListener('click', function() {
            editProfileCard.classList.remove('active');
            viewProfileCard.style.display = 'block';
        });
        
        // Submit Profile Form
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Update display values with input values
            displayName.textContent = inputName.value;
            displayEmail.textContent = inputEmail.value;
            displayPhone.textContent = inputPhone.value;
            
            // Hide edit form and show view card
            editProfileCard.classList.remove('active');
            viewProfileCard.style.display = 'block';
            
            // Show success message (optional)
            alert('Profil berhasil diperbarui!');
        });
        
        // Submit Password Form
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            // Validasi dasar
            if (!currentPassword || !newPassword || !confirmPassword) {
                alert('Semua field harus diisi!');
                return;
            }
            
            if (newPassword !== confirmPassword) {
                alert('Password baru dan konfirmasi password tidak cocok!');
                return;
            }
            
            // Clear form
            this.reset();
            
            // Show success message
            alert('Password berhasil diubah!');
        });
        
        // Handle avatar upload
        avatarUpload.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    profileAvatar.src = e.target.result;
                }
                
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection 
 
 