<!DOCTYPE html>
<html lang="id" data-theme="lemonade">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - {{ config('app.name') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif']
                    },
                }
            }
        };
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .input input {
            background-color: transparent !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .input input:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        input::-ms-reveal,
        input::-ms-clear {
            display: none;
        }

        input[type="password"]::-webkit-contacts-auto-fill-button,
        input[type="password"]::-webkit-credentials-auto-fill-button {
            visibility: hidden;
            display: none !important;
            pointer-events: none;
            position: absolute;
            right: 0;
        }

        @media (max-width: 320px) {
            .input {
                padding-right: 30px;
            }

            button.absolute.right-3 {
                right: 0.5rem;
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 font-poppins bg-base-100">
    <div class="w-full max-w-md card bg-base-200 shadow-xl">
        <div class="card-body">
            <div class="text-center mb-4">
                <h1 class="text-3xl font-bold text-primary">Daftar Akun</h1>
                <p class="mt-2 text-sm text-base-content/70">Silakan isi form untuk membuat akun baru</p>
            </div>

            <!-- Tema -->
            <div class="flex justify-center gap-2 mb-4">
                <button onclick="document.documentElement.setAttribute('data-theme', 'lemonade')" class="btn btn-circle btn-xs bg-success"></button>
                <button onclick="document.documentElement.setAttribute('data-theme', 'light')" class="btn btn-circle btn-xs bg-info"></button>
                <button onclick="document.documentElement.setAttribute('data-theme', 'dark')" class="btn btn-circle btn-xs bg-neutral"></button>
            </div>

            @if ($errors->any())
            <div class="alert alert-error mb-4">
                <div class="flex items-center">
                    <i class='bx bx-error-circle text-lg'></i>
                    <span class="ml-2">Terdapat kesalahan. Silakan periksa kembali form.</span>
                </div>
            </div>
            @endif

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

            <div class="mt-4 text-center text-sm">
                <p class="text-base-content/70">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="link link-hover link-primary">Masuk sekarang</a>
                </p>
            </div>
        </div>
    </div>

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
</body>
</html>
