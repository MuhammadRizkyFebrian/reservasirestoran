<!DOCTYPE html>
<html lang="id" data-theme="lemonade">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DaisyUI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />

    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Google Fonts - Poppins -->
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

    @yield('additional_styles')
</head>

<body class="min-h-screen flex items-center justify-center p-4 font-poppins bg-base-100">
    <div class="w-full max-w-md card bg-base-200 shadow-xl">
        <div class="card-body">
            <div class="text-center mb-4">
                <h1 class="text-3xl font-bold text-primary">@yield('page_title')</h1>
                <p class="mt-2 text-sm text-base-content/70">@yield('page_description')</p>
            </div>

            <!-- Switcher Tema -->
            <div class="flex justify-center gap-2 mb-4 hidden">
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

            <!-- Pesan Sukses -->
            @if (session('status'))
            <div class="alert alert-success mb-4">
                <div class="flex items-center">
                    <i class='bx bx-check-circle text-lg'></i>
                    <span class="ml-2">{{ session('status') }}</span>
                </div>
            </div>
            @endif

            @yield('content')

            @yield('footer')
        </div>
    </div>

    @yield('scripts')
</body>

</html>