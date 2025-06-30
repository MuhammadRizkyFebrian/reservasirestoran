<!-- Navbar Component -->
<div class="navbar sticky top-0 z-50 bg-base-300 shadow-md">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center w-full">
            <!-- Logo dan Menu Mobile -->
            <div class="flex items-center">
                <!-- Dropdown Menu Mobile -->
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-sm lg:hidden mr-1">
                        <i class='bx bx-menu text-xl'></i>
                    </div>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-60 max-h-[60vh] overflow-y-auto">
                        <li><a href="{{ route('menu') }}" class="flex items-center py-2"><i class='bx bx-food-menu mr-2'></i>Menu</a></li>
                        <li><a href="{{ route('home') }}#tentang" class="flex items-center py-2"><i class='bx bx-info-circle mr-2'></i>Tentang Kami</a></li>
                        <li><a href="{{ route('home') }}#promo" class="flex items-center py-2"><i class='bx bx-gift mr-2'></i>Promo</a></li>
                        <li><a href="{{ route('home') }}#ulasan" class="flex items-center py-2"><i class='bx bx-star mr-2'></i>Ulasan</a></li>
                        <li><a href="{{ route('reservation') }}" class="flex items-center py-2"><i class='bx bx-calendar mr-2'></i>Reservasi</a></li>
                    </ul>
                </div>

                <!-- Logo -->
                <a href="{{ route('home') }}" class="btn btn-ghost text-lg flex items-center p-0 sm:p-2">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-8 h-8 rounded-full mr-2">
                    <span class="font-bold text-base sm:text-xl">Seatify</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex">
                <ul class="menu menu-horizontal px-1 gap-1">
                    <li><a href="{{ route('menu') }}" class="hover:bg-base-200"><i class='bx bx-food-menu mr-1'></i>Menu</a></li>
                    <li><a href="{{ route('home') }}#tentang" class="hover:bg-base-200"><i class='bx bx-info-circle mr-1'></i>Tentang Kami</a></li>
                    <li><a href="{{ route('home') }}#promo" class="hover:bg-base-200"><i class='bx bx-gift mr-1'></i>Promo</a></li>
                    <li><a href="{{ route('home') }}#ulasan" class="hover:bg-base-200"><i class='bx bx-star mr-1'></i>Ulasan</a></li>
                    <li><a href="{{ route('reservation') }}" class="hover:bg-base-200"><i class='bx bx-calendar mr-1'></i>Reservasi</a></li>
                </ul>
            </div>

            <!-- Controls -->
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Theme Switcher -->
                <div class="dropdown dropdown-end">
                    <div tabindex="0" class="w-9 h-9 flex items-center justify-center cursor-pointer rounded-full hover:bg-base-200">
                        <i class='bx bx-palette text-lg'></i>
                    </div>
                    <div tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-200 rounded-box w-fit">
                        <div class="flex gap-1 p-1">
                            <button onclick="document.documentElement.setAttribute('data-theme', 'lemonade')"
                                class="btn btn-xs btn-circle bg-success" title="Tema Lemonade"></button>
                            <button onclick="document.documentElement.setAttribute('data-theme', 'light')"
                                class="btn btn-xs btn-circle bg-info" title="Tema Light"></button>
                            <button onclick="document.documentElement.setAttribute('data-theme', 'dark')"
                                class="btn btn-xs btn-circle bg-neutral" title="Tema Dark"></button>
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                @auth('pelanggan')
                <div class="dropdown dropdown-end">
                    <div tabindex="0" class="w-9 h-9 flex items-center justify-center cursor-pointer rounded-full hover:bg-base-200 overflow-hidden focus:ring-2 focus:ring-base-content/20 focus:outline-none">
                        @if(Auth::guard('pelanggan')->user()->foto_profil)
                        <img alt="Avatar" src="{{ asset('storage/profile/' . Auth::guard('pelanggan')->user()->foto_profil) }}" class="w-full h-full object-cover" />
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-primary text-primary-content font-medium">
                            {{ strtoupper(substr(Auth::guard('pelanggan')->user()->username, 0, 2)) }}
                        </div>
                        @endif
                    </div>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-200 rounded-box w-52">
                        <li>
                            <a href="{{ route('profile') }}" class="py-2">
                                <i class='bx bx-user mr-2'></i>
                                Profil
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('reservation-history') }}" class="py-2">
                                <i class='bx bx-history mr-2'></i>
                                Riwayat Reservasi
                            </a>
                        </li>
                        <li>
                            <a href="#" class="py-2" onclick="document.getElementById('logoutForm').submit(); return false;">
                                <i class='bx bx-log-out mr-2'></i>
                                Keluar
                            </a>
                            <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm h-9 flex items-center justify-center">
                    <i class='bx bx-log-in mr-1'></i>
                    Masuk
                </a>
                @endauth
            </div>
        </div>
    </div>
</div>