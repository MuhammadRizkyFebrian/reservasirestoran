<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->increments('id_ulasan');
            $table->integer('id_pelanggan');
            $table->integer('id_staf');
            $table->integer('rating');
            $table->text('komentar');
            // TODO: Review: `tgl_ulasan` date DEFAULT NULL
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
