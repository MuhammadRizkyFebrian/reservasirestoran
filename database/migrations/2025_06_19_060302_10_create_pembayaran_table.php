<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->increments('id_pembayaran');
            $table->integer('id_pemesanan');
            $table->decimal('total_harga', 10, 2);
            $table->enum('metode_pembayaran', ['bca', 'bni', 'bri', 'mandiri']);
            $table->enum('status_pembayaran', ['dikonfirmasi', 'menunggu', 'dibatalkan']);
            $table->integer('id_staf');
            $table->string('bukti_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
