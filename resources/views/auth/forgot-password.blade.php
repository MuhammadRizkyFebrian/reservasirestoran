@extends('auth.layouts.auth')

@section('title', 'Reset Password')
@section('page_title', 'Reset Password')
@section('page_description', 'Masukkan email Anda untuk menerima kode OTP')

@section('content')
<!-- Form Request OTP -->
<form action="{{ route('password.email') }}" method="POST" class="space-y-3" id="requestOtpForm" @if(session('show_otp_form')) style="display: none;" @endif>
    @csrf
    <div class="form-control">
        <label for="email" class="label py-1">
            <span class="label-text">Email Terdaftar</span>
        </label>
        <label class="input input-bordered flex items-center gap-2 @error('email') input-error @enderror">
            <i class='bx bx-envelope text-xl text-base-content/70'></i>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                class="grow"
                placeholder="Email terdaftar" required>
        </label>
        @error('email')
        <label class="label py-0">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary w-full text-white">
        Kirim Kode OTP
    </button>
</form>

<!-- Form Verifikasi OTP dan Reset Password -->
<form action="{{ route('password.update') }}" method="POST" class="space-y-3" id="resetPasswordForm" @if(!session('show_otp_form')) style="display: none;" @endif>
    @csrf
    <input type="hidden" name="email" value="{{ session('email') }}">

    <div class="form-control">
        <label for="otp" class="label py-1">
            <span class="label-text">Kode OTP</span>
        </label>
        <label class="input input-bordered flex items-center gap-2 @error('otp') input-error @enderror">
            <i class='bx bx-key text-xl text-base-content/70'></i>
            <input type="text" id="otp" name="otp"
                class="grow"
                placeholder="Masukkan kode OTP" required>
        </label>
        @error('otp')
        <label class="label py-0">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
    </div>

    <div class="form-control">
        <label for="password" class="label py-1">
            <span class="label-text">Password Baru</span>
        </label>
        <label class="input input-bordered flex items-center gap-2 @error('password') input-error @enderror relative">
            <i class='bx bx-lock-alt text-xl text-base-content/70'></i>
            <input type="password" id="password" name="password"
                class="grow"
                placeholder="Password baru" required>
            <button type="button" onclick="togglePassword('password', 'eye-icon-password')" class="absolute right-3">
                <i id="eye-icon-password" class='bx bx-hide text-xl text-base-content/70'></i>
            </button>
        </label>
        @error('password')
        <label class="label py-0">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
        @enderror
    </div>

    <div class="form-control">
        <label for="password_confirmation" class="label py-1">
            <span class="label-text">Konfirmasi Password Baru</span>
        </label>
        <label class="input input-bordered flex items-center gap-2 relative">
            <i class='bx bx-lock text-xl text-base-content/70'></i>
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="grow"
                placeholder="Konfirmasi password baru" required>
            <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-confirmation')" class="absolute right-3">
                <i id="eye-icon-confirmation" class='bx bx-hide text-xl text-base-content/70'></i>
            </button>
        </label>
    </div>

    <button type="submit" class="btn btn-primary w-full text-white">
        Reset Password
    </button>
</form>
@endsection

@section('footer')
<div class="text-center mt-4">
    <a href="{{ route('login') }}" class="link link-hover link-primary">
        Kembali ke Login
    </a>
</div>
@endsection

@section('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bx-hide');
            icon.classList.add('bx-show');
        } else {
            input.type = 'password';
            icon.classList.remove('bx-show');
            icon.classList.add('bx-hide');
        }
    }
</script>
@endsection