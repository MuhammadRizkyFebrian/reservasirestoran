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

.profile-image-container {
position: relative;
cursor: pointer;
transition: all 0.3s ease;
}

.profile-image-container:hover::after {
content: 'Ganti Foto';
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
background: rgba(0, 0, 0, 0.5);
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
color: white;
font-size: 0.875rem;
opacity: 1;
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
                    <div class="profile-image-container mb-4" onclick="document.getElementById('avatarUpload').click()">
                        @if($pelanggan->foto_profil)
                        <img src="{{ asset('storage/profile/' . $pelanggan->foto_profil) }}" alt="Profile" id="profileAvatar" class="profile-image">
                        @else
                        <div class="profile-image flex items-center justify-center bg-primary text-primary-content font-medium text-4xl">
                            {{ strtoupper(substr($pelanggan->username, 0, 2)) }}
                        </div>
                        @endif
                    </div>
                    <form id="uploadForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="hidden">
                        @csrf
                        <input type="file" name="foto_profil" id="avatarUpload" accept="image/*" onchange="submitForm()" />
                    </form>
                    <h2 class="text-xl font-bold mb-3">{{ $pelanggan->username }}</h2>
                    <div class="flex flex-col items-center space-y-2 text-center">
                        <div class="flex items-center">
                            <i class='bx bx-envelope text-base-content/70 mr-2'></i>
                            <span class="text-sm" id="displayEmail">{{ $pelanggan->email }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class='bx bx-phone text-base-content/70 mr-2'></i>
                            <span class="text-sm" id="displayPhone">{{ $pelanggan->nomor_handphone }}</span>
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
                        <span>Riwayat Reservasi</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-item w-full text-left">
                            <i class='bx bx-log-out'></i>
                            <span>Keluar</span>
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

            @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-error mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- View Card -->
            <div id="viewProfileCard" class="profile-card">
                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <p class="text-base-content/70 text-sm">Username</p>
                        <p class="font-medium" id="displayName">{{ $pelanggan->username }}</p>
                    </div>
                    <div>
                        <p class="text-base-content/70 text-sm">Email</p>
                        <p class="font-medium">{{ $pelanggan->email }}</p>
                    </div>
                    <div>
                        <p class="text-base-content/70 text-sm">Nomor Handphone</p>
                        <p class="font-medium">{{ $pelanggan->nomor_handphone }}</p>
                    </div>
                </div>
            </div>

            <!-- Edit Card -->
            <div id="editProfileCard" class="profile-card edit-form-card">
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-3">
                    @csrf
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text">Username</span>
                        </label>
                        <input type="text" name="username" class="input input-bordered input-sm" value="{{ $pelanggan->username }}" required />
                    </div>

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email" name="email" class="input input-bordered input-sm" value="{{ $pelanggan->email }}" required />
                    </div>

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text">Nomor Telepon</span>
                        </label>
                        <input type="tel" name="nomor_handphone" class="input input-bordered input-sm" value="{{ $pelanggan->nomor_handphone }}" required />
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

                <form action="{{ route('profile.update.password') }}" method="POST" class="space-y-3">
                    @csrf
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text">Password Lama</span>
                        </label>
                        <input type="password" name="current_password" class="input input-bordered input-sm" placeholder="Masukkan password lama" required />
                    </div>

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text">Password Baru</span>
                        </label>
                        <input type="password" name="new_password" class="input input-bordered input-sm" placeholder="Masukkan password baru" required />
                    </div>

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text">Konfirmasi Password Baru</span>
                        </label>
                        <input type="password" name="new_password_confirmation" class="input input-bordered input-sm" placeholder="Konfirmasi password baru" required />
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

        // Show Edit Form
        editProfileBtn.addEventListener('click', function() {
            viewProfileCard.style.display = 'none';
            editProfileCard.classList.add('active');
        });

        // Hide Edit Form
        cancelEditBtn.addEventListener('click', function() {
            viewProfileCard.style.display = 'block';
            editProfileCard.classList.remove('active');
        });
    });

    function submitForm() {
        document.getElementById('uploadForm').submit();
    }
</script>
@endsection