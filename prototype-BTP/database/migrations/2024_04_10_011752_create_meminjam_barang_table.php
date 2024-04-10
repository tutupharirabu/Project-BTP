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
        Schema::create('meminjam_barang', function (Blueprint $table) {
            $table->increments('id_meminjamBarang');
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_selesai');
            $table->unsignedInteger('id_penyewa');
            $table->unsignedInteger('id_barang');
            $table->foreign('id_penyewa')->references('id_penyewa')->on('penyewa');
            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meminjam_barang');
    }
};
