<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->integer('id');
            $table->string('queue');
            $table->text('payload');
            $table->integer('attempts');
            $table->integer('reserved_at');
            $table->integer('available_at');
            $table->integer('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
