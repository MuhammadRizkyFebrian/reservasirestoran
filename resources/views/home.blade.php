@extends('layouts.app')

@section('title', 'Dashboard - ' . config('app.name'))

@section('head')
@include('components.home.home-styles')
<style>
    html {
        scroll-behavior: smooth;
    }
</style>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success fixed top-0 left-1/2 transform -translate-x-1/2 mt-4 z-50 w-fit shadow-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span>{{ session('success') }}</span>
</div>
@endif
<!-- Hero Section -->
<div class="relative hero-section">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex items-center justify-center min-h-[60vh] sm:min-h-[70vh]">
            <div class="text-center text-white max-w-md">
                <h1 class="mb-3 sm:mb-5 text-3xl sm:text-5xl font-bold">Selamat Datang</h1>
                <p class="mb-4 sm:mb-5 text-sm sm:text-base">Rasakan pengalaman makan malam yang tak terlupakan dengan suasana misterius dan hidangan istimewa dari dapur kami.</p>
                <a href="{{ route('reservation') }}" class="btn btn-soft btn-warning">Pesan Meja</a>
            </div>
        </div>
    </div>
</div>

<!-- Menu Section -->
<section id="menu" class="py-8 sm:py-10 px-4 md:px-10">
    <div class="container mx-auto">
        <h2 class="text-2xl sm:text-3xl font-bold text-center mb-6 sm:mb-8">Makanan & Minuman</h2>

        <div class="grid card-container gap-4 sm:gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($menus as $menu)
            <div class="card card-menu bg-base-200 shadow-xl overflow-hidden">
                <figure class="h-40 sm:h-48">
                    <img src="{{ asset('storage/menu/' . $menu->gambar) }}" class="w-full h-full object-cover" alt="{{ $menu->nama }}">
                </figure>
                <div class="card-body p-4 sm:p-6">
                    <h3 class="card-title text-base sm:text-lg">{{ $menu->nama }}</h3>
                    <p class="text-sm sm:text-base">{{ $menu->deskripsi }}</p>
                    <div class="card-actions justify-end mt-2">
                        <span class="badge badge-warning text-xs sm:text-sm px-4 py-4 text-base">Rp{{ number_format($menu->harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            @empty
            <p class="col-span-3 text-center text-gray-500">Menu belum tersedia.</p>
            @endforelse
        </div>

        <div class="text-center mt-6 sm:mt-8">
            <a href="{{ route('menu') }}" class="btn btn-warning btn-sm sm:btn-md">Lihat lainnya...</a>
        </div>
    </div>
</section>

<!-- Tentang Kami Section -->
<section id="tentang" class="py-8 sm:py-10 px-4 md:px-10 bg-base-200">
    <div class="container mx-auto">
        <div class="grid md:grid-cols-2 gap-6 sm:gap-8 items-center">
            <div class="order-2 md:order-1">
                <h2 class="text-2xl sm:text-3xl font-bold mb-3 sm:mb-4">Tentang Kami</h2>
                <p class="mb-2 sm:mb-3 text-sm sm:text-base">Didirikan pada tahun 2023, Restoran Seatify hadir dengan konsep modern yang menggabungkan cita rasa lokal dan internasional.</p>
                <p class="mb-2 sm:mb-3 text-sm sm:text-base">Kami berkomitmen untuk menyajikan pengalaman kuliner yang tak terlupakan dengan hidangan berkualitas tinggi dan layanan ramah dalam atmosfir yang nyaman dan elegan.</p>
                <p class="text-sm sm:text-base">Setiap hidangan kami dibuat dengan bahan-bahan segar dan berkualitas, dimasak oleh tim chef profesional yang berpengalaman dalam bidangnya.</p>

                <div class="mt-4 sm:mt-6 flex flex-wrap gap-2 sm:gap-3">
                    <div class="badge badge-outline p-2 sm:p-3 text-xs sm:text-sm">Fresh Ingredients</div>
                    <div class="badge badge-outline p-2 sm:p-3 text-xs sm:text-sm">Expert Chefs</div>
                    <div class="badge badge-outline p-2 sm:p-3 text-xs sm:text-sm">Cozy Atmosphere</div>
                    <div class="badge badge-outline p-2 sm:p-3 text-xs sm:text-sm">Exceptional Service</div>
                </div>
            </div>

            <div class="order-1 md:order-2">
                <img src="https://images.unsplash.com/photo-1600565193348-f74bd3c7ccdf?q=80&w=1170&auto=format&fit=crop" alt="Restaurant Interior" class="rounded-lg shadow-lg w-full h-auto">
            </div>
        </div>
    </div>
</section>

<!-- Promo Section -->
<section id="promo" class="py-8 sm:py-10 px-4 md:px-10">
    <div class="container mx-auto">
        <h2 class="text-2xl sm:text-3xl font-bold text-center mb-6 sm:mb-8">Promo Spesial</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Promo 1 -->
            <div class="promo-card h-56 sm:h-64 md:h-250" style="background-image: url('https://images.unsplash.com/photo-1528605248644-14dd04022da1?q=80&w=1170&auto=format&fit=crop')">
                <div class="promo-content text-white">
                    <h3 class="text-lg sm:text-xl font-bold mb-1 sm:mb-2">Happy Hour</h3>
                    <p class="mb-3 sm:mb-4 text-sm sm:text-base">Diskon 20% untuk semua minuman dari jam 4-6 sore, setiap hari Senin-Jumat.</p>
                    <button class="btn btn-xs sm:btn-sm btn-warning">Lihat Detail</button>
                </div>
            </div>

            <!-- Promo 2 -->
            <div class="promo-card h-56 sm:h-64 md:h-250" style="background-image: url('https://images.unsplash.com/photo-1559329007-40df8a9345d8?q=80&w=1074&auto=format&fit=crop')">
                <div class="promo-content text-white">
                    <h3 class="text-lg sm:text-xl font-bold mb-1 sm:mb-2">Weekend Special</h3>
                    <p class="mb-3 sm:mb-4 text-sm sm:text-base">Paket makan untuk 4 orang hanya Rp500.000, setiap Sabtu dan Minggu.</p>
                    <button class="btn btn-xs sm:btn-sm btn-warning">Lihat Detail</button>
                </div>
            </div>

            <!-- Promo 3 -->
            <div class="promo-card h-56 sm:h-64 md:h-250" style="background-image: url('https://images.unsplash.com/photo-1529417305485-480f579e7578?q=80&w=1169&auto=format&fit=crop')">
                <div class="promo-content text-white">
                    <h3 class="text-lg sm:text-xl font-bold mb-1 sm:mb-2">Birthday Package</h3>
                    <p class="mb-3 sm:mb-4 text-sm sm:text-base">Gratis kue dan minuman spesial untuk yang berulang tahun (min. 4 orang).</p>
                    <button class="btn btn-xs sm:btn-sm btn-warning">Lihat Detail</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Ulasan Section -->
<section id="ulasan" class="py-8 sm:py-10 px-4 md:px-10 bg-base-200">
    <div class="container mx-auto">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 sm:mb-8">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold">Ulasan Pelanggan</h2>
                <!-- Statistik Rating -->
                <div id="ratingStats" class="mt-2 flex items-center gap-3">
                    <div class="rating-summary flex items-center">
                        <span id="avgRating" class="text-lg sm:text-xl font-bold">{{ $avgRating }}</span>
                        <div class="flex ml-2">
                            <i class='bx bxs-star text-accent text-lg sm:text-xl'></i>
                        </div>
                    </div>
                    <span class="text-base-content/70">|</span>
                    <div id="totalReviews" class="text-sm sm:text-base text-base-content/70">{{ $totalReviews }} ulasan</div>
                </div>
            </div>
            @if(auth()->guard('pelanggan')->check())
            <label for="modal-ulasan" class="btn btn-warning mt-4 sm:mt-0">Tambah Ulasan</label>
            @else
            <a href="{{ route('login') }}" class="btn btn-warning mt-4 sm:mt-0">Login untuk Menambah Ulasan</a>
            @endif
        </div>

        <!-- Daftar Ulasan -->
        <div id="ulasanSection" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @forelse($ulasans as $review)
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body p-4 sm:p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="avatar mb-2 sm:mb-3">
                                <div class="w-10 sm:w-12 rounded-full">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->pelanggan->username ?? 'User') }}&background=random" />
                                </div>
                            </div>
                            <h3 class="font-bold text-base sm:text-lg">{{ $review->pelanggan->username ?? 'Anonim' }}</h3>
                        </div>
                    </div>
                    <div class="flex mb-2 sm:mb-3 text-yellow-400 text-xl">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($review->star_rating >= $i)
                            <i class='bx bxs-star'></i>
                            @elseif ($review->star_rating >= $i - 0.5)
                            <i class='bx bxs-star-half'></i>
                            @else
                            <i class='bx bx-star text-gray-400'></i>
                            @endif
                            @endfor
                    </div>
                    <p class="text-sm sm:text-base mb-4">"{{ $review->comments }}"</p>

                    @if(auth()->guard('pelanggan')->check() && $review->id_pelanggan == auth()->guard('pelanggan')->user()->id_pelanggan)
                    <div class="flex gap-2">
                        <!-- Tombol Edit -->
                        <button class="btn btn-sm btn-success" onclick="editUlasan({{ $review->id }}, `{{ $review->comments }}`, {{ $review->star_rating }})">
                            Edit
                        </button>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('ulasan.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-error" type="submit">Hapus</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <p class="text-center col-span-3 text-gray-500">Belum ada ulasan.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-8 sm:py-10 px-4 md:px-10">
    <div class="container mx-auto">
        <div class="text-center">
            <h2 class="text-2xl sm:text-3xl font-bold mb-3 sm:mb-4">Reservasi Sekarang</h2>
            <p class="mb-6 sm:mb-8 max-w-2xl mx-auto text-sm sm:text-base">Jangan lewatkan pengalaman bersantap yang luar biasa. Reservasi meja Anda sekarang dan nikmati hidangan spesial dari chef kami!</p>
            <a href="{{ route('reservation') }}" class="btn btn-warning">Pesan Meja</a>
        </div>
    </div>
</section>

<!-- Modal Tambah Ulasan -->
<input type="checkbox" id="modal-ulasan" class="modal-toggle" />
<div class="modal">
    <div class="modal-box max-w-md">
        <h3 id="modalTitle" class="font-bold text-lg mb-3">Tambah Ulasan Baru</h3>
        @if($lastOrder)
        <form method="POST" id="reviewFormElement">
            @csrf
            <input type="hidden" name="id_pelanggan" value="{{ auth()->guard('pelanggan')->user()->id_pelanggan }}">
            <input type="hidden" name="id_pemesanan" value="{{ $lastOrder->id_pemesanan }}">

            <div class="form-control mb-3">
                <label class="label"><span class="label-text">Nama</span></label>
                <input type="text" value="{{ Auth::guard('pelanggan')->user()->username ?? '' }}" class="input input-bordered w-full" readonly>
            </div>

            <div class="form-control mb-4" x-data="{ rating: 0 }">
                <label class="label">
                    <span class="label-text">Rating</span>
                </label>
                <div class="flex items-center gap-1 text-2xl text-gray-400">
                    <template x-for="star in 5" :key="star">
                        <svg @click="rating = star"
                            @mouseover="rating = star"
                            @mouseleave="rating = rating"
                            :class="star <= rating ? 'text-yellow-400' : 'text-gray-300'"
                            class="w-7 h-7 cursor-pointer transition-all duration-150"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.122-6.545L0.487 6.91l6.572-.955L10 0l2.941 5.955 6.572.955-4.757 4.635 1.122 6.545z" />
                        </svg>
                    </template>
                </div>
                <input type="hidden" name="star_rating" x-model="rating">
                <span class="text-sm text-gray-600 mt-1 block">Rating: <span x-text="rating"></span> bintang</span>
            </div>

            <div class="form-control mb-4">
                <label class="label"><span class="label-text">Ulasan</span></label>
                <textarea name="comments" id="reviewText" class="textarea textarea-bordered h-24" required></textarea>
            </div>

            <div class="modal-action">
                <label for="modal-ulasan" class="btn">Batal</label>
                <button type="button" id="submitReview" class="btn btn-primary">Simpan</button>
            </div>
        </form>
        @else
        <div class="text-center py-4">
            <p class="text-error mb-2">Anda belum memiliki riwayat pemesanan.</p>
            <p class="text-sm text-base-content/70">Silakan lakukan reservasi terlebih dahulu untuk memberikan ulasan.</p>
            <div class="mt-4">
                <a href="{{ route('reservation') }}" class="btn btn-primary">Reservasi Sekarang</a>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal Edit Ulasan -->
<input type="checkbox" id="modal-edit-ulasan" class="modal-toggle" />
<div class="modal" role="dialog">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Edit Ulasan</h3>
        <form id="editReviewForm" method="POST" action="{{ route('ulasan.update') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit_id">

            <div class="mb-3">
                <label for="edit_comments" class="label">Komentar</label>
                <textarea id="edit_comments" name="comments" class="textarea textarea-bordered w-full" required></textarea>
            </div>

            <div class="mb-3">
                <label for="edit_rating" class="label">Rating</label>
                <select id="edit_rating" name="star_rating" class="select select-bordered w-full" required>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} Bintang</option>
                        @endfor
                </select>
            </div>

            <div class="modal-action">
                <label for="modal-edit-ulasan" class="btn">Batal</label>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Remove alert after 3 seconds
    setTimeout(function() {
        var alert = document.querySelector('.alert');
        if (alert) alert.remove();
    }, 3000);

    // Handle review submission
    document.getElementById('submitReview').addEventListener('click', function() {
        var form = document.getElementById('reviewFormElement');
        var formData = new FormData(form);
        var token = document.querySelector('input[name="_token"]').value;

        fetch("{{ route('ulasan.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    alert(data.message);
                    document.getElementById('modal-ulasan').checked = false;
                    window.location.reload();
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(function(error) {
                alert("Terjadi kesalahan: " + error.message);
            });
    });

    // Smooth scroll
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                var targetId = this.getAttribute('href');
                var targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });

    // Edit review
    function editUlasan(id, comments, rating) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_comments').value = comments;
        document.getElementById('edit_rating').value = rating;
        document.getElementById('modal-edit-ulasan').checked = true;
    }
</script>

@endsection