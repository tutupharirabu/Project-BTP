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
            $table->bigInteger('jumlah_pengguna')->nullable();
            $table->bigInteger('jumlah_barang')->nullable();
            $table->unsignedInteger('id_penyewa');
            $table->unsignedInteger('id_barang')->nullable();
            $table->unsignedInteger('id_ruangan')->nullable();
            $table->unsignedInteger('id_meminjamBarang')->nullable();
            $table->unsignedInteger('id_meminjamRuangan')->nullable();
            $table->string('status', 255)->default('Sedang Menunggu')->nullable();
            $table->foreign('id_penyewa')->references('id_penyewa')->on('penyewa');
            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangan');
            $table->foreign('id_meminjamBarang')->references('id_meminjamBarang')->on('meminjam_barang');
            $table->foreign('id_meminjamRuangan')->references('id_meminjamRuangan')->on('meminjam_ruangan');
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
