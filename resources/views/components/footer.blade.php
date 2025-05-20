<!-- Footer Component -->
<footer class="bg-base-300 text-base-content mt-8">
    <!-- Main Footer -->
    <div class="footer p-6 sm:p-10">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8">
                <!-- Brand -->
                <div>
                    <div class="flex flex-col items-center sm:items-start">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full mb-2">
                        <p class="font-bold text-lg mb-1">Seatify</p>
                        <p class="text-sm sm:text-base text-center sm:text-left">Memberikan pengalaman kuliner terbaik sejak 2023</p>
                    </div>
                </div>

                <!-- Contact Info -->
                <div>
                    <span class="footer-title mb-3">Kontak Kami</span>
                    <div class="flex items-center mb-2">
                        <i class='bx bx-phone mr-2 text-lg'></i>
                        <span class="text-sm sm:text-base">+62 822 8644 1928</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <i class='bx bx-envelope mr-2 text-lg'></i>
                        <span class="text-sm sm:text-base">info@seatify.com</span>
                    </div>
                    <div class="flex mt-3 space-x-2">
                        <a href="#" class="btn btn-xs btn-circle btn-outline hover:bg-accent hover:border-accent" title="Facebook">
                            <i class='bx bxl-facebook text-lg'></i>
                        </a>
                        <a href="#" class="btn btn-xs btn-circle btn-outline hover:bg-accent hover:border-accent" title="Instagram">
                            <i class='bx bxl-instagram text-lg'></i>
                        </a>
                        <a href="#" class="btn btn-xs btn-circle btn-outline hover:bg-accent hover:border-accent" title="Twitter">
                            <i class='bx bxl-twitter text-lg'></i>
                        </a>
                        <a href="#" class="btn btn-xs btn-circle btn-outline hover:bg-accent hover:border-accent" title="YouTube">
                            <i class='bx bxl-youtube text-lg'></i>
                        </a>
                    </div>
                </div>

                <!-- Hours -->
                <div>
                    <span class="footer-title mb-3">Jam Operasional</span>
                    <ul class="space-y-1">
                        <li class="text-sm sm:text-base flex items-center">
                            <i class='bx bx-time-five mr-2 text-lg'></i>
                            <span>Senin - Jumat: 11:00 - 22:00</span>
                        </li>
                        <li class="text-sm sm:text-base flex items-center">
                            <i class='bx bx-time-five mr-2 text-lg'></i>
                            <span>Sabtu - Minggu: 10:00 - 23:00</span>
                        </li>
                        <li class="text-sm sm:text-base flex items-center">
                            <i class='bx bx-time-five mr-2 text-lg'></i>
                            <span>Hari Libur: 10:00 - 23:00</span>
                        </li>
                    </ul>
                </div>

                <!-- Location -->
                <div>
                    <span class="footer-title mb-3">Lokasi</span>
                    <div class="w-full h-32 sm:h-40 rounded-lg overflow-hidden mb-2">
                        <img src="images/lokasi.png" alt="Map" class="w-full h-full object-cover">
                    </div>
                    <a href="https://maps.app.goo.gl/Qdq6PGTHE1nD5hNy7" target="_blank" class="btn btn-xs btn-accent">
                        <i class='bx bx-map mr-1'></i> Buka di Maps
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright Footer -->
    <div class="footer footer-center p-4 bg-base-300 text-base-content border-t border-base-200">
        <div class="container mx-auto">
            <p class="text-sm">Copyright © {{ date('Y') }} Seatify - All rights reserved</p>
        </div>
    </div>
</footer>