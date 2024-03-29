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
        Schema::create('ruangan', function (Blueprint $table) {
            $table->increments('id_ruangan');
            $table->string('nama_ruangan', 255);
            $table->bigInteger('kapasitas_ruangan');
            $table->bigInteger('jumlah_peserta');
            $table->date('tanggal_pemesanan');
            $table->time('waktu_mulai');
            $table->time('waktu_berakhir');
            $table->unsignedInteger('id_petugas');
            $table->unsignedInteger('id_penyewa');
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas');
            $table->foreign('id_penyewa')->references('id_penyewa')->on('penyewa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};
