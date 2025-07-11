<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id');
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->text('failed_job_ids');
            $table->text('options');
            $table->integer('cancelled_at');
            $table->integer('created_at');
            $table->integer('finished_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_batches');
    }
};
