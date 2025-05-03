<!DOCTYPE html>
<html lang="id" data-theme="lemonade">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name') }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- DaisyUI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    
    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        // Konfigurasi tema Tailwind
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
        
        /* Menghilangkan outline pada input saat focus */
        .input input:focus {
            outline: none !important;
            box-shadow: none !important;
        }
        
        /* Menghilangkan tombol show password bawaan browser */
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
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 font-poppins bg-base-100">
    <div class="w-full max-w-md card bg-base-200 shadow-xl">
        <div class="card-body">
            <div class="text-center mb-4">
                <h1 class="text-3xl font-bold text-primary">Selamat Datang</h1>
                <p class="mt-2 text-sm text-base-content/70">Silakan masuk untuk melanjutkan</p>
            </div>
            
            <!-- Switcher Tema -->
            <div class="flex justify-center gap-2 mb-4">
                <button onclick="document.documentElement.setAttribute('data-theme', 'lemonade')" 
                    class="btn btn-circle btn-xs bg-success border-2 border-base-100" title="Tema Lemonade"></button>
                <button onclick="document.documentElement.setAttribute('data-theme', 'light')" 
                    class="btn btn-circle btn-xs bg-info border-2 border-base-100" title="Tema Light"></button>
                <button onclick="document.documentElement.setAttribute('data-theme', 'dark')" 
                    class="btn btn-circle btn-xs bg-neutral border-2 border-base-100" title="Tema Dark"></button>
            </div>
            
            <!-- Pesan Error -->
            @if ($errors->any())
            <div class="alert alert-error mb-4">
                <div class="flex items-center">
                    <i class='bx bx-error-circle text-lg'></i>
                    <span class="ml-2">{{ $errors->first() }}</span>
                </div>
            </div>
            @endif
            
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
                            placeholder="Masukkan username" required>
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
                            placeholder="Masukkan password" required>
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
            
            <!-- Register Link -->
            <div class="mt-4 text-center text-sm">
                <p class="text-base-content/70">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="link link-hover link-primary">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Script untuk toggle password -->
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