<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('staf_restoran', function (Blueprint $table) {
            $table->increments('id_staf');
            $table->string('username');
            $table->string('password');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staf_restoran');
    }
};
