<!-- Table Selector Component -->
<div class="card bg-base-200 shadow-xl">
    <div class="card-body">
        <h2 class="card-title text-xl font-bold mb-4">Denah Meja Restoran</h2>
        
        <div class="mb-4">
            <div class="flex items-center gap-4 mb-2 flex-wrap status-legend">
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-[#86efac] border border-[#22c55e] rounded-sm mr-2"></div>
                    <span>Tersedia</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-[#fca5a5] border border-[#ef4444] rounded-sm mr-2"></div>
                    <span>Dipesan</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-[#93c5fd] border border-[#3b82f6] rounded-sm mr-2"></div>
                    <span>Dipilih</span>
                </div>
            </div>
        </div>
        
        <!-- Gambar PNG Denah Restoran -->
        <div class="mb-4">
            <img src="{{ asset('images/restaurant_floor_plan (1).png') }}" alt="Denah Restoran" class="w-full h-auto rounded-lg shadow-md">
        </div>
        
        <!-- Tombol Meja -->
        <div class="mt-6">
            <h3 class="font-bold text-lg mb-3">Pilih Meja</h3>
            
            <!-- Area 1: Meja Bundar -->
            <div class="mb-4">
                <h4 class="font-semibold mb-2">Meja Bundar</h4>
                <div class="table-grid">
                    <button class="table-btn available" data-table="1" data-price="50000">Meja 1</button>
                    <button class="table-btn available" data-table="2" data-price="50000">Meja 2</button>
                    <button class="table-btn available" data-table="3" data-price="50000">Meja 3</button>
                    <button class="table-btn reserved" data-table="4" data-price="50000">Meja 4</button>
                </div>
            </div>
            
            <!-- Area 2: Meja Tengah -->
            <div class="mb-4">
                <h4 class="font-semibold mb-2">Meja Tengah</h4>
                <div class="table-grid">
                    <button class="table-btn available" data-table="5" data-price="65000">Meja 5</button>
                    <button class="table-btn available" data-table="6" data-price="65000">Meja 6</button>
                    <button class="table-btn reserved" data-table="7" data-price="65000">Meja 7</button>
                    <button class="table-btn available" data-table="8" data-price="65000">Meja 8</button>
                </div>
            </div>
            
            <!-- Area 3: Meja Persegi Panjang -->
            <div class="mb-4">
                <h4 class="font-semibold mb-2">Meja Persegi Panjang</h4>
                <div class="table-grid">
                    <button class="table-btn available" data-table="9" data-price="75000">Meja 9</button>
                    <button class="table-btn available" data-table="10" data-price="75000">Meja 10</button>
                    <button class="table-btn reserved" data-table="11" data-price="75000">Meja 11</button>
                    <button class="table-btn available" data-table="12" data-price="75000">Meja 12</button>
                </div>
            </div>
            
            <!-- Area 4: Meja VIP -->
            <div>
                <h4 class="font-semibold mb-2">Meja VIP</h4>
                <div class="table-grid">
                    <button class="table-btn available" data-table="13" data-price="120000">VIP-1</button>
                    <button class="table-btn reserved" data-table="14" data-price="120000">VIP-2</button>
                </div>
            </div>
        </div>
    </div>
</div> 