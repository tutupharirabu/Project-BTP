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
        Schema::create('pengelolaan', function (Blueprint $table) {
            $table->increments('id_pengelolaan');
            $table->unsignedInteger('id_users');
            $table->unsignedInteger('id_barang');
            $table->unsignedInteger('id_ruangan');
            $table->foreign('id_users')->references('id_users')->on('users');
            $table->foreign('id_barang')->references('id_barang')->on('barang')->nullable();
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangan')->nullable();
            $table->date('tanggal');
            $table->string('keterangan', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengelolaan');
    }
};
