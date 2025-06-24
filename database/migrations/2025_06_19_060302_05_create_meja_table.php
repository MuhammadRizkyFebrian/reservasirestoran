<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meja', function (Blueprint $table) {
            $table->increments('no_meja');
            $table->enum('tipe_meja', ['persegi', 'bundar', 'persegi panjang', 'vip']);
            $table->integer('kapasitas');
            $table->integer('id_staf');
            $table->enum('status', ['tersedia', 'dipesan']);
            $table->decimal('harga', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meja');
    }
};
