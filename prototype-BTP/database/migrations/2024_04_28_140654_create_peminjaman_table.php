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
            $table->unsignedInteger('id_users');
            $table->unsignedInteger('id_ruangan');
            $table->unsignedInteger('id_barang');
            $table->foreign('id_users')->references('id_users')->on('users');
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangan')->nullable();
            $table->foreign('id_barang')->references('id_barang')->on('barang')->nullable();
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->bigInteger('jumlah');
            $table->string('status', 255);
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
