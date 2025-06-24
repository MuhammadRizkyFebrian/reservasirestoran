<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('resi', function (Blueprint $table) {
            $table->increments('id_transaksi');
            $table->integer('id_pembayaran');
            $table->string('kode_resi');
            $table->text('detail_pesanan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resi');
    }
};
