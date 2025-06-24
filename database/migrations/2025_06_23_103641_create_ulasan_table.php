<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('id_pemesanan');
            $table->unsignedBigInteger('id_pelanggan');
            $table->longText('comments')->nullable();
            $table->integer('star_rating');
            $table->enum('status', ['active','deactive'])->default('active');
            $table->timestamps();

            // Foreign key ke tabel pemesanan
            $table->foreign('id_pemesanan')->references('id_pemesanan')->on('pemesanan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
