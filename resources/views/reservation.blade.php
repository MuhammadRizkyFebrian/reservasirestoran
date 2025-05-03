@extends('layouts.app')

@section('title', 'Pemilihan Meja - ' . config('app.name'))

@section('head')
    @include('components.reservation.reservation-styles')
@endsection

@section('content')
    <!-- Header -->
    @component('components.page-header')
        @slot('title', 'Pemilihan Meja')
        @slot('subtitle', 'Pilih meja yang tersedia untuk pengalaman bersantap terbaik Anda')
    @endcomponent

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Table Selection -->
            <div class="lg:col-span-2">
                @include('components.reservation.table-selector')
            </div>

            <!-- Right Column - Reservation Form -->
            <div>
                @include('components.reservation.reservation-form')
            </div>
        </div>
    </div>

    <!-- Modals -->
    @include('components.reservation.payment-modal')
    @include('components.reservation.success-modal')
@endsection

@section('modals')
    @include('components.terms-modal')
@endsection

@section('scripts')
    @include('components.reservation.reservation-scripts')
@endsection 