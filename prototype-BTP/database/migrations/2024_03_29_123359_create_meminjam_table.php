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
        Schema::create('meminjam', function (Blueprint $table) {
            $table->increments('id_peminjaman');
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_selesai');
            $table->bigInteger('jumlah_pengguna');
            $table->unsignedInteger('id_penyewa');
            $table->unsignedInteger('id_barang');
            $table->unsignedInteger('id_ruangan');
            $table->foreign('id_penyewa')->references('id_penyewa')->on('penyewa');
            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meminjam');
    }
};
