<!-- Menu Filter Component -->
<div class="bg-base-100 py-6">
    <div class="container mx-auto px-4">
        <form id="menuFilterForm" class="bg-base-200 shadow-md rounded-md p-4 max-w-5xl mx-auto">
            <div class="flex flex-col md:flex-row gap-4 items-stretch">
                <!-- Search Input -->
                <div class="form-control w-full md:flex-1">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class='bx bx-search text-gray-500'></i>
                        </span>
                        <input type="text" id="searchInput" placeholder="Cari menu..." class="input input-bordered w-full pl-10 h-12" autocomplete="off" />
                    </div>
                </div>

                <!-- Filter Controls -->
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <!-- Category Filter -->
                    <div class="relative">
                        <select id="categoryFilter" class="select select-bordered w-full sm:w-[200px] h-12 pr-8">
                            <option value="">Semua Kategori</option>
                            <option value="Daging">Daging</option>
                            <option value="Seafood">Seafood</option>
                            <option value="Pasta">Pasta</option>
                            <option value="Salad">Salad</option>
                            <option value="Cocktail">Cocktail</option>
                            <option value="Wine">Wine</option>
                            <option value="Kopi">Kopi</option>
                            <option value="Teh">Teh</option>
                            <option value="Non-Alkohol">Non-Alkohol</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <i class="bx bx-chevron-down text-gray-500"></i>
                        </div>
                    </div>

                    <!-- Type Filter -->
                    <div class="relative">
                        <select id="typeFilter" class="select select-bordered w-full sm:w-[160px] h-12 pr-8">
                            <option value="">Semua Tipe</option>
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <i class="bx bx-chevron-down text-gray-500"></i>
                        </div>
                    </div>

                    <!-- Reset Button -->
                    <button type="reset" id="resetButton" class="btn btn-outline h-12 min-h-0 px-3 sm:px-4">
                        <i class='bx bx-reset'></i>
                        <span class="hidden sm:inline ml-1">Reset</span>
                    </button>
                </div>
            </div>

            <!-- Filter Results Counter -->
            <div id="filterResults" class="mt-3 pl-1 text-sm hidden">
                <span id="resultCount">0</span> menu ditemukan
            </div>
        </form>
    </div>
</div>