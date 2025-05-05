@extends('layouts.app')

@section('title', 'Dashboard - ' . config('app.name'))

@section('head')
    @include('components.home.home-styles')
@endsection

@section('content')
    <!-- Hero Section -->
    <div class="relative hero-section">
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="flex items-center justify-center min-h-[60vh] sm:min-h-[70vh]">
                <div class="text-center text-white max-w-md">
                    <h1 class="mb-3 sm:mb-5 text-3xl sm:text-5xl font-bold">Selamat Datang</h1>
                    <p class="mb-4 sm:mb-5 text-sm sm:text-base">Rasakan pengalaman makan malam yang tak terlupakan dengan suasana misterius dan hidangan istimewa dari dapur kami.</p>
                    <a href="{{ route('reservation') }}" class="btn btn-primary btn-sm sm:btn-md">Pesan Meja</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Section -->
    <section id="menu" class="py-8 sm:py-10 px-4 md:px-10">
        <div class="container mx-auto">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-6 sm:mb-8">Makanan & Minuman</h2>
            
            <div class="grid card-container gap-4 sm:gap-6">
                <!-- Menu Item 1 -->
                <div class="card card-menu bg-base-200 shadow-xl overflow-hidden">
                    <figure class="h-40 sm:h-48"><img src="https://images.unsplash.com/photo-1607330289024-1535c6b4e1c1?q=80&w=1936&auto=format&fit=crop" class="w-full h-full object-cover" alt="Makanan"></figure>
                    <div class="card-body p-4 sm:p-6">
                        <h3 class="card-title text-base sm:text-lg">Seafood Special</h3>
                        <p class="text-sm sm:text-base">Fresh seafood with special sauce</p>
                        <div class="card-actions justify-end mt-2">
                            <span class="badge badge-primary text-xs sm:text-sm">Rp120.000</span>
                        </div>
                    </div>
                </div>
                
                <!-- Menu Item 2 -->
                <div class="card card-menu bg-base-200 shadow-xl overflow-hidden">
                    <figure class="h-40 sm:h-48"><img src="https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=1169&auto=format&fit=crop" class="w-full h-full object-cover" alt="Makanan"></figure>
                    <div class="card-body p-4 sm:p-6">
                        <h3 class="card-title text-base sm:text-lg">Steak & Mushrooms</h3>
                        <p class="text-sm sm:text-base">Premium beef with sautéed mushrooms</p>
                        <div class="card-actions justify-end mt-2">
                            <span class="badge badge-primary text-xs sm:text-sm">Rp150.000</span>
                        </div>
                    </div>
                </div>
                
                <!-- Menu Item 3 -->
                <div class="card card-menu bg-base-200 shadow-xl overflow-hidden">
                    <figure class="h-40 sm:h-48"><img src="https://images.unsplash.com/photo-1536935338788-846bb9981813?q=80&w=1172&auto=format&fit=crop" class="w-full h-full object-cover" alt="Makanan"></figure>
                    <div class="card-body p-4 sm:p-6">
                        <h3 class="card-title text-base sm:text-lg">Signature Cocktail</h3>
                        <p class="text-sm sm:text-base">Refreshing mix with local ingredients</p>
                        <div class="card-actions justify-end mt-2">
                            <span class="badge badge-primary text-xs sm:text-sm">Rp80.000</span>
                        </div>
                    </div>
                </div>
                
                <!-- Menu Item 4 -->
                <div class="card card-menu bg-base-200 shadow-xl overflow-hidden">
                    <figure class="h-40 sm:h-48"><img src="https://images.unsplash.com/photo-1576866209830-589e1bfbaa4d?q=80&w=1170&auto=format&fit=crop" class="w-full h-full object-cover" alt="Makanan"></figure>
                    <div class="card-body p-4 sm:p-6">
                        <h3 class="card-title text-base sm:text-lg">Chef's Special</h3>
                        <p class="text-sm sm:text-base">Daily creation by our head chef</p>
                        <div class="card-actions justify-end mt-2">
                            <span class="badge badge-primary text-xs sm:text-sm">Rp135.000</span>
                        </div>
                    </div>
                </div>
                
                <!-- Menu Item 5 -->
                <div class="card card-menu bg-base-200 shadow-xl overflow-hidden">
                    <figure class="h-40 sm:h-48"><img src="https://images.unsplash.com/photo-1612203985729-70726954388c?q=80&w=1064&auto=format&fit=crop" class="w-full h-full object-cover" alt="Makanan"></figure>
                    <div class="card-body p-4 sm:p-6">
                        <h3 class="card-title text-base sm:text-lg">Chocolate Delight</h3>
                        <p class="text-sm sm:text-base">Rich dessert with local chocolate</p>
                        <div class="card-actions justify-end mt-2">
                            <span class="badge badge-primary text-xs sm:text-sm">Rp45.000</span>
                        </div>
                    </div>
                </div>
                
                <!-- Menu Item 6 -->
                <div class="card card-menu bg-base-200 shadow-xl overflow-hidden">
                    <figure class="h-40 sm:h-48"><img src="https://images.unsplash.com/photo-1635685296916-95acaf58471f?q=80&w=1171&auto=format&fit=crop" class="w-full h-full object-cover" alt="Makanan"></figure>
                    <div class="card-body p-4 sm:p-6">
                        <h3 class="card-title text-base sm:text-lg">Creamy Pasta</h3>
                        <p class="text-sm sm:text-base">Pasta with creamy sauce and herbs</p>
                        <div class="card-actions justify-end mt-2">
                            <span class="badge badge-primary text-xs sm:text-sm">Rp95.000</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-6 sm:mt-8">
                <a href="{{ route('menu') }}" class="btn btn-primary btn-sm sm:btn-md">Lihat Menu Lengkap</a>
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
                        <button class="btn btn-xs sm:btn-sm btn-primary">Lihat Detail</button>
                    </div>
                </div>
                
                <!-- Promo 2 -->
                <div class="promo-card h-56 sm:h-64 md:h-250" style="background-image: url('https://images.unsplash.com/photo-1559329007-40df8a9345d8?q=80&w=1074&auto=format&fit=crop')">
                    <div class="promo-content text-white">
                        <h3 class="text-lg sm:text-xl font-bold mb-1 sm:mb-2">Weekend Special</h3>
                        <p class="mb-3 sm:mb-4 text-sm sm:text-base">Paket makan untuk 4 orang hanya Rp500.000, setiap Sabtu dan Minggu.</p>
                        <button class="btn btn-xs sm:btn-sm btn-primary">Lihat Detail</button>
                    </div>
                </div>
                
                <!-- Promo 3 -->
                <div class="promo-card h-56 sm:h-64 md:h-250" style="background-image: url('https://images.unsplash.com/photo-1529417305485-480f579e7578?q=80&w=1169&auto=format&fit=crop')">
                    <div class="promo-content text-white">
                        <h3 class="text-lg sm:text-xl font-bold mb-1 sm:mb-2">Birthday Package</h3>
                        <p class="mb-3 sm:mb-4 text-sm sm:text-base">Gratis kue dan minuman spesial untuk yang berulang tahun (min. 4 orang).</p>
                        <button class="btn btn-xs sm:btn-sm btn-primary">Lihat Detail</button>
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
                    <div id="ratingStats" class="mt-2 flex items-center gap-3">
                        <div class="rating-summary flex items-center">
                            <span id="avgRating" class="text-lg sm:text-xl font-bold">0</span>
                            <div class="flex ml-2">
                                <i class='bx bxs-star text-warning text-lg sm:text-xl'></i>
                            </div>
                        </div>
                        <span class="text-base-content/70">|</span>
                        <div id="totalReviews" class="text-sm sm:text-base text-base-content/70">0 ulasan</div>
                    </div>
                </div>
                <button id="addReviewBtn" class="btn btn-primary mt-4 sm:mt-0">Tambah Ulasan</button>
            </div>
            
            <!-- Daftar Ulasan -->
            <div id="reviewsList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Ulasan akan di-render secara dinamis menggunakan JavaScript -->
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-8 sm:py-10 px-4 md:px-10">
        <div class="container mx-auto">
            <div class="text-center">
                <h2 class="text-2xl sm:text-3xl font-bold mb-3 sm:mb-4">Reservasi Sekarang</h2>
                <p class="mb-6 sm:mb-8 max-w-2xl mx-auto text-sm sm:text-base">Jangan lewatkan pengalaman bersantap yang luar biasa. Reservasi meja Anda sekarang dan nikmati hidangan spesial dari chef kami!</p>
                <a href="{{ route('reservation') }}" class="btn btn-primary">Pesan Meja</a>
            </div>
        </div>
    </section>
@endsection

@section('modals')
    <!-- Modal Tambah/Edit Ulasan -->
    <dialog id="reviewModal" class="modal">
        <div class="modal-box max-w-md">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 id="modalTitle" class="font-bold text-lg mb-3">Tambah Ulasan Baru</h3>
            <form id="reviewFormElement">
                <input type="hidden" id="reviewId">
                <div class="form-control mb-3">
                    <label class="label">
                        <span class="label-text">Nama</span>
                    </label>
                    <input type="text" id="reviewerName" class="input input-bordered w-full" required>
                </div>
                
                <div class="form-control mb-3">
                    <label class="label">
                        <span class="label-text">Rating</span>
                    </label>
                    <div class="rating rating-lg">
                        <input type="radio" name="rating" id="rate1" value="1.0" class="hidden">
                        <input type="radio" name="rating" id="rate15" value="1.5" class="hidden">
                        <input type="radio" name="rating" id="rate2" value="2.0" class="hidden">
                        <input type="radio" name="rating" id="rate25" value="2.5" class="hidden">
                        <input type="radio" name="rating" id="rate3" value="3.0" class="hidden">
                        <input type="radio" name="rating" id="rate35" value="3.5" class="hidden">
                        <input type="radio" name="rating" id="rate4" value="4.0" class="hidden">
                        <input type="radio" name="rating" id="rate45" value="4.5" class="hidden">
                        <input type="radio" name="rating" id="rate5" value="5.0" checked class="hidden">
                        
                        <div class="flex flex-wrap gap-1">
                            <div class="flex items-center" title="1 Bintang">
                                <label for="rate1" class="cursor-pointer"><i class='bx bxs-star star-icon text-gray-400 hover:text-warning text-xl mr-1'></i></label>
                            </div>
                            <div class="flex items-center" title="1.5 Bintang">
                                <label for="rate15" class="cursor-pointer"><i class='bx bxs-star-half star-icon text-gray-400 hover:text-warning text-xl mr-1'></i></label>
                            </div>
                            <div class="flex items-center" title="2 Bintang">
                                <label for="rate2" class="cursor-pointer"><i class='bx bxs-star star-icon text-gray-400 hover:text-warning text-xl mr-1'></i></label>
                            </div>
                            <div class="flex items-center" title="2.5 Bintang">
                                <label for="rate25" class="cursor-pointer"><i class='bx bxs-star-half star-icon text-gray-400 hover:text-warning text-xl mr-1'></i></label>
                            </div>
                            <div class="flex items-center" title="3 Bintang">
                                <label for="rate3" class="cursor-pointer"><i class='bx bxs-star star-icon text-gray-400 hover:text-warning text-xl mr-1'></i></label>
                            </div>
                            <div class="flex items-center" title="3.5 Bintang">
                                <label for="rate35" class="cursor-pointer"><i class='bx bxs-star-half star-icon text-gray-400 hover:text-warning text-xl mr-1'></i></label>
                            </div>
                            <div class="flex items-center" title="4 Bintang">
                                <label for="rate4" class="cursor-pointer"><i class='bx bxs-star star-icon text-gray-400 hover:text-warning text-xl mr-1'></i></label>
                            </div>
                            <div class="flex items-center" title="4.5 Bintang">
                                <label for="rate45" class="cursor-pointer"><i class='bx bxs-star-half star-icon text-gray-400 hover:text-warning text-xl mr-1'></i></label>
                            </div>
                            <div class="flex items-center" title="5 Bintang">
                                <label for="rate5" class="cursor-pointer"><i class='bx bxs-star star-icon text-gray-400 hover:text-warning text-xl'></i></label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Ulasan</span>
                    </label>
                    <textarea id="reviewText" class="textarea textarea-bordered h-24" required></textarea>
                </div>
                
                <div class="flex justify-end gap-2">
                    <button type="button" id="cancelReviewBtn" class="btn">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Modal Konfirmasi Hapus -->
    <dialog id="confirmDeleteModal" class="modal">
        <div class="modal-box max-w-xs">
            <h3 class="font-bold text-lg mb-3">Konfirmasi Penghapusan</h3>
            <p>Apakah Anda yakin ingin menghapus ulasan ini?</p>
            <div class="modal-action">
                <button class="btn btn-ghost" onclick="confirmDeleteModal.close()">Batal</button>
                <button id="confirmDeleteBtn" class="btn btn-error">Hapus</button>
            </div>
        </div>
    </dialog>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data ulasan (statis sebagai contoh)
        let reviews = [
            {
                id: 1,
                name: "John Doe",
                rating: 4.5,
                text: "Makanan lezat dengan penyajian yang menarik. Pelayanannya juga sangat baik dan ramah. Saya pasti akan kembali lagi!"
            },
            {
                id: 2,
                name: "Jane Smith",
                rating: 5.0,
                text: "Saya merayakan ulang tahun di sini dan mendapat perlakuan istimewa dari seluruh staf. Makanan enak, suasana bagus, dan layanan luar biasa!"
            },
            {
                id: 3,
                name: "Ahmad Nugraha",
                rating: 4.7,
                text: "Pelayanan cepat, makanan enak dan hangat. Suasananya nyaman untuk pertemuan bisnis maupun acara keluarga."
            },
        ];
        
        // Pilih elemen-elemen DOM
        const reviewsList = document.getElementById('reviewsList');
        const reviewModal = document.getElementById('reviewModal');
        const reviewFormElement = document.getElementById('reviewFormElement');
        const modalTitle = document.getElementById('modalTitle');
        const addReviewBtn = document.getElementById('addReviewBtn');
        const cancelReviewBtn = document.getElementById('cancelReviewBtn');
        const confirmDeleteModal = document.getElementById('confirmDeleteModal');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const avgRatingElement = document.getElementById('avgRating');
        const totalReviewsElement = document.getElementById('totalReviews');
        
        // ID dari ulasan yang akan dihapus
        let reviewToDelete = null;
        
        // Update statistik rating
        function updateRatingStats() {
            const totalReviews = reviews.length;
            let totalRating = 0;
            
            reviews.forEach(review => {
                totalRating += review.rating;
            });
            
            // Menggunakan nilai dengan 1 angka di belakang koma untuk rata-rata rating
            const avgRating = totalReviews > 0 ? (totalRating / totalReviews).toFixed(1) : '0.0';
            
            avgRatingElement.textContent = avgRating;
            totalReviewsElement.textContent = `${totalReviews} ulasan`;
        }
        
        // Render ulasan
        function renderReviews() {
            reviewsList.innerHTML = '';
            
            reviews.forEach(review => {
                const stars = getStarsHTML(review.rating);
                
                const reviewCard = document.createElement('div');
                reviewCard.className = 'card bg-base-100 shadow-xl';
                reviewCard.innerHTML = `
                    <div class="card-body p-4 sm:p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="avatar mb-2 sm:mb-3">
                                    <div class="w-10 sm:w-12 rounded-full">
                                        <img src="https://ui-avatars.com/api/?name=${review.name.replace(' ', '+')}&background=random" />
                                    </div>
                                </div>
                                <h3 class="font-bold text-base sm:text-lg">${review.name}</h3>
                            </div>
                            <div class="flex gap-1 sm:gap-2">
                                <button class="btn btn-xs sm:btn-sm btn-ghost edit-review" data-id="${review.id}">
                                    <i class='bx bx-edit text-base sm:text-lg'></i>
                                </button>
                                <button class="btn btn-xs sm:btn-sm btn-ghost delete-review" data-id="${review.id}">
                                    <i class='bx bx-trash text-base sm:text-lg text-error'></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex mb-2 sm:mb-3">
                            ${stars}
                        </div>
                        <p class="text-sm sm:text-base">"${review.text}"</p>
                    </div>
                `;
                
                reviewsList.appendChild(reviewCard);
            });
            
            // Update rating statistics
            updateRatingStats();
            
            // Tambahkan event listeners untuk tombol edit dan hapus
            document.querySelectorAll('.edit-review').forEach(button => {
                button.addEventListener('click', function() {
                    const id = parseInt(this.getAttribute('data-id'));
                    editReview(id);
                });
            });
            
            document.querySelectorAll('.delete-review').forEach(button => {
                button.addEventListener('click', function() {
                    const id = parseInt(this.getAttribute('data-id'));
                    reviewToDelete = id;
                    confirmDeleteModal.showModal();
                });
            });
        }
        
        // Menghasilkan HTML untuk bintang rating
        function getStarsHTML(rating) {
            let stars = '';
            // Mendapatkan bagian bulat dan desimal dari rating
            const fullStars = Math.floor(rating);
            const decimal = rating - fullStars;
            const hasHalfStar = decimal >= 0.3 && decimal < 0.8;
            const hasFullStar = decimal >= 0.8;
            
            // Tambahkan bintang penuh
            for (let i = 0; i < fullStars; i++) {
                stars += `<i class='bx bxs-star text-warning text-base sm:text-xl'></i>`;
            }
            
            // Tambahkan bintang setengah jika perlu
            if (hasHalfStar) {
                stars += `<i class='bx bxs-star-half text-warning text-base sm:text-xl'></i>`;
            } else if (hasFullStar) {
                stars += `<i class='bx bxs-star text-warning text-base sm:text-xl'></i>`;
            }
            
            // Tambahkan bintang kosong yang tersisa
            const remainingStars = 5 - fullStars - (hasHalfStar || hasFullStar ? 1 : 0);
            for (let i = 0; i < remainingStars; i++) {
                stars += `<i class='bx bx-star text-warning text-base sm:text-xl'></i>`;
            }
            
            return stars;
        }
        
        // Edit ulasan
        function editReview(id) {
            const review = reviews.find(r => r.id === id);
            if (!review) return;
            
            document.getElementById('reviewId').value = review.id;
            document.getElementById('reviewerName').value = review.name;
            document.getElementById('reviewText').value = review.text;
            
            // Set rating
            const ratingValue = Math.ceil(review.rating);
            document.querySelector(`input[name="rating"][value="${ratingValue}"]`).checked = true;
            updateStarRating(ratingValue);
            
            modalTitle.textContent = 'Edit Ulasan';
            reviewModal.showModal();
        }
        
        // Fungsi untuk update tampilan bintang rating berdasarkan nilai yang dipilih
        function updateStarRating(value) {
            const ratingInputs = document.querySelectorAll('input[name="rating"]');
            
            // Temukan input yang sesuai dengan nilai yang dipilih
            ratingInputs.forEach(input => {
                if (parseFloat(input.value) === parseFloat(value)) {
                    input.checked = true;
                }
            });
            
            // Perbarui tampilan bintang sesuai dengan nilai yang dipilih
            document.querySelector(`input[name="rating"][value="${value}"]`).checked = true;
        }
        
        // Tambah ulasan baru
        addReviewBtn.addEventListener('click', function() {
            // Reset form
            reviewFormElement.reset();
            document.getElementById('reviewId').value = '';
            modalTitle.textContent = 'Tambah Ulasan Baru';
            document.getElementById('rate5').checked = true;
            updateStarRating(5);
            
            reviewModal.showModal();
        });
        
        // Batal tambah/edit ulasan
        cancelReviewBtn.addEventListener('click', function() {
            reviewModal.close();
        });
        
        // Submit form ulasan
        reviewFormElement.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const reviewId = document.getElementById('reviewId').value;
            const name = document.getElementById('reviewerName').value;
            const text = document.getElementById('reviewText').value;
            const rating = document.querySelector('input[name="rating"]:checked').value;
            
            if (reviewId) {
                // Edit ulasan yang ada
                const index = reviews.findIndex(r => r.id === parseInt(reviewId));
                if (index !== -1) {
                    reviews[index] = {
                        id: parseInt(reviewId),
                        name,
                        rating: parseFloat(rating), // Simpan sebagai nilai float
                        text
                    };
                }
            } else {
                // Tambah ulasan baru
                const newId = reviews.length > 0 ? Math.max(...reviews.map(r => r.id)) + 1 : 1;
                reviews.push({
                    id: newId,
                    name,
                    rating: parseFloat(rating), // Simpan sebagai nilai float
                    text
                });
            }
            
            // Render ulang daftar ulasan
            renderReviews();
            
            // Tutup modal
            reviewModal.close();
        });
        
        // Konfirmasi hapus ulasan
        confirmDeleteBtn.addEventListener('click', function() {
            if (reviewToDelete) {
                reviews = reviews.filter(r => r.id !== reviewToDelete);
                renderReviews();
                reviewToDelete = null;
                confirmDeleteModal.close();
            }
        });
        
        // Inisialisasi tampilan ulasan
        renderReviews();
        
        // Aktifkan bintang rating
        const starLabels = document.querySelectorAll('.rating label');
        starLabels.forEach(label => {
            const input = document.getElementById(label.getAttribute('for'));
            
            label.addEventListener('mouseover', function() {
                // Highlight bintang yang di-hover dan sebelumnya
                const value = parseInt(input.value);
                updateStarRating(value);
            });
            
            input.addEventListener('change', function() {
                const value = parseInt(this.value);
                updateStarRating(value);
            });
        });
        
        // Scroll behavior untuk navbar links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>
@endsection 