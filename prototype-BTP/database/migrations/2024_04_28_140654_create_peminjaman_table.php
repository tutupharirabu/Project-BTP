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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->increments('id_peminjaman');
            $table->unsignedInteger('id_users')->nullable();
            // $table->string('invoice', 255);
            $table->string('nama_peminjam', 255);
            $table->string('role', 255);
            $table->string('nomor_induk',255);
            $table->string('nomor_telepon',255);
            $table->unsignedInteger('id_ruangan')->nullable();
            $table->foreign('id_users')->references('id_users')->on('users');
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangan');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->bigInteger('jumlah');
            $table->string('total_harga', 255);
            $table->string('status', 255);
            $table->string('keterangan', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
