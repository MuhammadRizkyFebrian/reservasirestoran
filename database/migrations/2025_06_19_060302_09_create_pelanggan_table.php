<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->increments('id_pelanggan');
            $table->string('username');
            $table->string('password');
            $table->string('email');
            $table->string('nomor_handphone');
            $table->string('remember_token')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
