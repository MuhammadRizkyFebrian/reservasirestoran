@extends('auth.layouts.auth')

@section('title', 'Register')
@section('page_title', 'Daftar Akun')
@section('page_description', 'Silakan isi form untuk membuat akun baru')

@section('content')
<form action="{{ route('register') }}" method="POST" class="space-y-3">
    @csrf

    <!-- Email -->
    <div class="form-control">
        <label for="email" class="label py-1">
            <span class="label-text">Email</span>
        </label>
        <label class="input input-bordered flex items-center gap-2 @error('email') input-error @enderror">
            <i class='bx bx-envelope text-xl'></i>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="grow" placeholder="Email" required>
        </label>
        @error('email')
        <label class="label py-0">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
    </div>

    <!-- Username -->
    <div class="form-control">
        <label for="username" class="label py-1">
            <span class="label-text">Username</span>
        </label>
        <label class="input input-bordered flex items-center gap-2 @error('username') input-error @enderror">
            <i class='bx bx-user text-xl'></i>
            <input type="text" id="username" name="username" value="{{ old('username') }}" class="grow" placeholder="Username" required>
        </label>
        @error('username')
        <label class="label py-0">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
    </div>

    <!-- Password -->
    <div class="form-control">
        <label for="password" class="label py-1">
            <span class="label-text">Password</span>
        </label>
        <label class="input input-bordered flex items-center gap-2 @error('password') input-error @enderror relative">
            <i class='bx bx-lock-alt text-xl'></i>
            <input type="password" id="password" name="password" class="grow" placeholder="Password" required>
            <button type="button" onclick="togglePassword()" class="absolute right-3">
                <i id="eye-icon" class='bx bx-hide text-xl'></i>
            </button>
        </label>
        @error('password')
        <label class="label py-0">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
    </div>

    <!-- Password Confirmation -->
    <div class="form-control">
        <label for="password_confirmation" class="label py-1">
            <span class="label-text">Konfirmasi Password</span>
        </label>
        <label class="input input-bordered flex items-center gap-2">
            <i class='bx bx-lock text-xl'></i>
            <input type="password" id="password_confirmation" name="password_confirmation" class="grow" placeholder="Konfirmasi Password" required>
        </label>
    </div>

    <!-- Nomor Handphone -->
    <div class="form-control">
        <label for="nomor_handphone" class="label py-1">
            <span class="label-text">Nomor Handphone</span>
        </label>
        <label class="input input-bordered flex items-center gap-2 @error('nomor_handphone') input-error @enderror">
            <i class='bx bx-phone text-xl'></i>
            <input type="number" id="nomor_handphone" name="nomor_handphone" value="{{ old('nomor_handphone') }}" class="grow" placeholder="08xxxxxxxxxx" required>
        </label>
        @error('nomor_handphone')
        <label class="label py-0">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
    </div>

    <!-- Submit -->
    <div class="mt-4">
        <button type="submit" class="btn btn-primary w-full">
            <i class='bx bx-user-plus mr-2'></i> Daftar
        </button>
    </div>
</form>
@endsection

@section('footer')
<div class="mt-4 text-center text-sm">
    <p class="text-base-content/70">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="link link-hover link-primary">Masuk sekarang</a>
    </p>
</div>
@endsection

@section('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('bx-hide');
            eyeIcon.classList.add('bx-show');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('bx-show');
            eyeIcon.classList.add('bx-hide');
        }
    }
</script>
@endsection