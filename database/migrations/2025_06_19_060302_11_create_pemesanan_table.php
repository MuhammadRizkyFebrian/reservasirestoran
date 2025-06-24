<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->increments('id_pemesanan'); // Auto increment primary key
            $table->unsignedInteger('id_pelanggan');
            $table->string('kode_transaksi'); // Ini dipakai untuk grup reservasi multi-meja
            $table->integer('no_meja');
            $table->string('nama_pemesan');
            $table->integer('jumlah_tamu');
            $table->string('no_handphone');
            $table->text('catatan')->nullable();
            $table->dateTime('jadwal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};

