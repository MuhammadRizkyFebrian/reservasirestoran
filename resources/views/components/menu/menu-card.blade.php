<!-- Menu Card Component -->
<div class="card menu-item-card bg-base-100 shadow-xl" 
    data-title="{{ $title }}" 
    data-category="{{ $category }}" 
    data-type="{{ $type ?? ($category == 'Daging' || $category == 'Seafood' || $category == 'Pasta' || $category == 'Salad' ? 'makanan' : 'minuman') }}"
    data-description="{{ $description }}">
    <figure><img src="{{ $image }}" alt="{{ $title }}" class="h-60 w-full object-cover" /></figure>
    <div class="card-body">
        <div class="flex justify-between items-start">
            <h3 class="card-title">{{ $title }}</h3>
            <span class="badge-tag">{{ $category }}</span>
        </div>
        <p>{{ $description }}</p>
        <div class="card-actions justify-end mt-2">
            <p class="font-bold text-xl">Rp {{ number_format($price, 0, ',', '.') }}</p>
        </div>
    </div>
</div> 