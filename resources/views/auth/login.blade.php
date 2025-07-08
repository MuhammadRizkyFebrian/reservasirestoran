@extends('auth.layouts.auth')

@section('title', 'Login')
@section('page_title', 'Selamat Datang')
@section('page_description', 'Silakan masuk untuk melanjutkan')

@section('content')
<form action="{{ route('login') }}" method="POST" class="space-y-3">
    @csrf

    <!-- Username Input -->
    <div class="form-control">
        <label for="username" class="label py-1">
            <span class="label-text">Username</span>
        </label>
        <label class="input input-bordered flex items-center gap-2 @error('username') input-error @enderror">
            <i class='bx bx-user text-xl text-base-content/70'></i>
            <input type="text" id="username" name="username" value="{{ old('username') }}"
                class="grow"
                placeholder="Username" required>
        </label>
        @error('username')
        <label class="label py-0">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
    </div>

    <!-- Password Input -->
    <div class="form-control">
        <label for="password" class="label py-1">
            <span class="label-text">Password</span>
        </label>
        <label class="input input-bordered flex items-center gap-2 @error('password') input-error @enderror relative">
            <i class='bx bx-lock-alt text-xl text-base-content/70'></i>
            <input type="password" id="password" name="password"
                class="grow"
                placeholder="Password" required>
            <button type="button" onclick="togglePassword()" class="absolute right-3">
                <i id="eye-icon" class='bx bx-hide text-xl text-base-content/70'></i>
            </button>
        </label>
        @error('password')
        <label class="label py-0">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
    </div>

    <!-- Remember Me & Forgot Password -->
    <div class="flex items-center justify-between mt-2">
        <div class="form-control">
            <label class="label cursor-pointer py-0">
                <input id="remember_me" name="remember" type="checkbox" class="checkbox checkbox-primary checkbox-sm">
                <span class="label-text ml-2">Ingat saya</span>
            </label>
        </div>

        <div class="text-sm">
            <a href="{{ route('password.request') }}" class="link link-hover link-primary">
                Lupa password?
            </a>
        </div>
    </div>

    <!-- Login Button -->
    <div class="mt-4">
        <button type="submit" class="btn btn-primary w-full">
            <i class='bx bx-log-in mr-2 text-lg'></i> Masuk
        </button>
    </div>
</form>
@endsection

@section('footer')
<div class="mt-4 text-center text-sm">
    <p class="text-base-content/70">
        Belum punya akun?
        <a href="{{ route('register') }}" class="link link-hover link-primary">
            Daftar sekarang
        </a>
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