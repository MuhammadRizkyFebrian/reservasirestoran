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
<div class="container mx-auto px-2 md:px-4 py-4 md:py-6 bg-base-100">
    <h2 class="text-3xl font-bold mb-8 text-base-content">Makanan</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 md:gap-4 lg:gap-2">
        @foreach($makanan as $item)
        @component('components.menu.menu-card')
        @slot('image', $item->gambar ? asset('storage/menu/' . $item->gambar) : asset('images/placeholder.jpg'))
        @slot('title', $item->nama)
        @slot('category', ucfirst($item->kategori))
        @slot('type', $item->tipe)
        @slot('description', $item->deskripsi)
        @slot('price', $item->harga)
        @endcomponent
        @endforeach
    </div>
</div>

<!-- Minuman Section -->
<div class="container mx-auto px-4 py-8 bg-base-100">
    <h2 class="text-3xl font-bold mb-8 text-base-content">Minuman</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 md:gap-4 lg:gap-2">
        @foreach($minuman as $item)
        @component('components.menu.menu-card')
        @slot('image', asset('storage/menu/' . $item->gambar))
        @slot('title', $item->nama)
        @slot('category', ucfirst($item->kategori))
        @slot('type', $item->tipe)
        @slot('description', $item->deskripsi)
        @slot('price', $item->harga)
        @endcomponent
        @endforeach
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