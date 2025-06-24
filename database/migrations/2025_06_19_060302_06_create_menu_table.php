<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id_menu');
            $table->integer('id_staf');
            $table->string('nama');
            $table->string('gambar');
            $table->string('kategori');
            $table->enum('tipe', ['makanan', 'minuman']);
            $table->text('deskripsi');
            $table->decimal('harga', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
