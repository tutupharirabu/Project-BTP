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
            $table->uuid('id_peminjaman')->primary();
            $table->string('nama_peminjam', 255);
            $table->enum('role', ['Pegawai', 'Mahasiswa', 'Umum']);
            $table->string('nomor_induk',255);
            $table->string('nomor_telepon',255);
            $table->string('ktp_url')->nullable();
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->bigInteger('jumlah');
            $table->string('total_harga', 255);
            $table->enum('status', ['Disetujui', 'Menunggu', 'Ditolak']);
            $table->string('keterangan', 255);
            $table->uuid('id_users')->nullable();
            $table->uuid('id_ruangan');
            $table->foreign('id_users')->references('id_users')->on('users')->onDelete('cascade');
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangan')->onDelete('cascade');
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
