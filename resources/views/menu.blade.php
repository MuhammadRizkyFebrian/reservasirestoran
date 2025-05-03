@extends('layouts.app')

@section('title', 'Menu - ' . config('app.name'))

@section('head')
    @include('components.menu.menu-styles')
@endsection

@section('content')
    <!-- Menu Header -->
    @component('components.page-header')
        @slot('title', 'Menu Kami')
        @slot('subtitle', 'Temukan pilihan makanan dan minuman premium kami')
    @endcomponent

    <!-- Menu Filter Section -->
    @include('components.menu.menu-filter')

    <!-- Makanan Section -->
    <div class="container mx-auto px-4 py-8 bg-base-100">
        <h2 class="text-3xl font-bold mb-6 text-base-content">Makanan</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Wagyu Steak -->
            @component('components.menu.menu-card')
                @slot('image', 'https://images.unsplash.com/photo-1600891964092-4316c288032e?q=80&w=2070&auto=format&fit=crop')
                @slot('title', 'Wagyu Steak')
                @slot('category', 'Daging')
                @slot('type', 'makanan')
                @slot('description', 'Daging sapi Wagyu premium dimasak sempurna dengan tingkat kematangan sesuai selera')
                @slot('price', 350000)
            @endcomponent
            
            <!-- Seafood Platter -->
            @component('components.menu.menu-card')
                @slot('image', 'https://stemandspoon.com/wp-content/uploads/2022/11/seafood-charcuterie-board-featured-720x720.jpg')
                @slot('title', 'Seafood Platter')
                @slot('category', 'Seafood')
                @slot('type', 'makanan')
                @slot('description', 'Kombinasi udang, cumi, dan ikan segar dimasak dengan saus spesial')
                @slot('price', 280000)
            @endcomponent
            
            <!-- Pasta Carbonara -->
            @component('components.menu.menu-card')
                @slot('image', 'https://images.unsplash.com/photo-1612874742237-6526221588e3?q=80&w=2071&auto=format&fit=crop')
                @slot('title', 'Pasta Carbonara')
                @slot('category', 'Pasta')
                @slot('type', 'makanan')
                @slot('description', 'Spaghetti dengan saus krim telur, keju parmesan, dan potongan bacon')
                @slot('price', 120000)
            @endcomponent
            
            <!-- Caesar Salad -->
            @component('components.menu.menu-card')
                @slot('image', 'https://images.unsplash.com/photo-1550304943-4f24f54ddde9?q=80&w=2070&auto=format&fit=crop')
                @slot('title', 'Caesar Salad')
                @slot('category', 'Salad')
                @slot('type', 'makanan')
                @slot('description', 'Selada romaine, crouton, keju parmesan, dengan dressing caesar')
                @slot('price', 85000)
            @endcomponent
            
            <!-- Grilled Salmon -->
            @component('components.menu.menu-card')
                @slot('image', 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?q=80&w=2070&auto=format&fit=crop')
                @slot('title', 'Grilled Salmon')
                @slot('category', 'Seafood')
                @slot('type', 'makanan')
                @slot('description', 'Fillet salmon premium dipanggang dengan bumbu pilihan dan sayuran segar')
                @slot('price', 190000)
            @endcomponent
            
            <!-- Beef Burger -->
            @component('components.menu.menu-card')
                @slot('image', 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=1899&auto=format&fit=crop')
                @slot('title', 'Beef Burger')
                @slot('category', 'Daging')
                @slot('type', 'makanan')
                @slot('description', 'Burger daging sapi dengan keju, selada, tomat, dan saus spesial')
                @slot('price', 135000)
            @endcomponent
        </div>
    </div>

    <!-- Minuman Section -->
    <div class="container mx-auto px-4 py-8 bg-base-100">
        <h2 class="text-3xl font-bold mb-6 text-base-content">Minuman</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Signature Cocktail -->
            @component('components.menu.menu-card')
                @slot('image', 'https://images.unsplash.com/photo-1536935338788-846bb9981813?q=80&w=1172&auto=format&fit=crop')
                @slot('title', 'Signature Cocktail')
                @slot('category', 'Cocktail')
                @slot('type', 'minuman')
                @slot('description', 'Campuran unik dengan gin, elderflower, dan jeruk segar')
                @slot('price', 120000)
            @endcomponent
            
            <!-- Red Wine -->
            @component('components.menu.menu-card')
                @slot('image', 'https://images.unsplash.com/photo-1553361371-9b22f78e8b1d?q=80&w=1974&auto=format&fit=crop')
                @slot('title', 'Red Wine')
                @slot('category', 'Wine')
                @slot('type', 'minuman')
                @slot('description', 'Anggur merah premium dengan aroma buah dan rempah')
                @slot('price', 650000)
            @endcomponent
            
            <!-- Cold Brew Coffee -->
            @component('components.menu.menu-card')
                @slot('image', 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?q=80&w=1969&auto=format&fit=crop')
                @slot('title', 'Cold Brew Coffee')
                @slot('category', 'Kopi')
                @slot('type', 'minuman')
                @slot('description', 'Kopi diseduh dingin selama 12 jam untuk rasa yang maksimal')
                @slot('price', 45000)
            @endcomponent
            
            <!-- Green Tea -->
            @component('components.menu.menu-card')
                @slot('image', 'https://images.unsplash.com/photo-1627435601361-ec25f5b1d0e5?q=80&w=2070&auto=format&fit=crop')
                @slot('title', 'Green Tea')
                @slot('category', 'Teh')
                @slot('type', 'minuman')
                @slot('description', 'Teh hijau Jepang berkualitas tinggi')
                @slot('price', 35000)
            @endcomponent
            
            <!-- Mango Smoothie -->
            @component('components.menu.menu-card')
                @slot('image', 'https://images.unsplash.com/photo-1623065422902-30a2d299bbe4?q=80&w=1974&auto=format&fit=crop')
                @slot('title', 'Mango Smoothie')
                @slot('category', 'Non-Alkohol')
                @slot('type', 'minuman')
                @slot('description', 'Smoothie mangga segar dengan yogurt dan madu')
                @slot('price', 55000)
            @endcomponent
            
            <!-- Sparkling Water -->
            @component('components.menu.menu-card')
                @slot('image', 'https://akcdn.detik.net.id/visual/2021/08/25/air-soda-sparkling-water_169.jpeg?w=1200')
                @slot('title', 'Sparkling Water')
                @slot('category', 'Non-Alkohol')
                @slot('type', 'minuman')
                @slot('description', 'Air berkarbonasi premium dengan sentuhan jeruk nipis')
                @slot('price', 30000)
            @endcomponent
        </div>
    </div>
    
    <!-- Keterangan -->
    <div class="container mx-auto px-4 py-8 bg-base-100">
        <div class="bg-base-200 p-4 rounded-lg">
            <h3 class="font-bold mb-2">Keterangan:</h3>
            <ul class="text-sm space-y-1">
                <li>* Harga belum termasuk pajak 10%</li>
                <li>* Menu dapat berubah sesuai ketersediaan bahan</li>
                <li>* Silakan informasikan kepada staf kami jika Anda memiliki alergi makanan</li>
            </ul>
        </div>
    </div>
@endsection

@section('scripts')
    @include('components.menu.menu-scripts')
@endsection 