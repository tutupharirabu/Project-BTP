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
        Schema::create('gambar', function (Blueprint $table) {
            $table->increments('id_gambar');
            $table->unsignedInteger('id_ruangan');
            $table->unsignedInteger('id_barang');
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangan')->nullable();
            $table->foreign('id_barang')->references('id_barang')->on('barang')->nullable();
            $table->string('url', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gambar');
    }
};
