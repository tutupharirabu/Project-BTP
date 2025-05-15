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
            $table->uuid('id_ruangan')->primary();
            $table->string('nama_ruangan', 255);
            // $table->string('ukuran', 255);
            $table->bigInteger('kapasitas_minimal');
            $table->bigInteger('kapasitas_maksimal');
            $table->string('satuan', 255);
            $table->string('lokasi', 255);
            $table->string('harga_ruangan', 255);
            // $table->boolean('tersedia');
            $table->string('keterangan', 255);
            $table->string('status', 255);
            $table->uuid('id_users');
            $table->foreign('id_users')->references('id_users')->on('users')->nullable()->onDelete('cascade');
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
