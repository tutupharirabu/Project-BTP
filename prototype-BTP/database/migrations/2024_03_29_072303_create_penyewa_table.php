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
        Schema::create('penyewa', function (Blueprint $table) {
            $table->increments('id_penyewa');
            $table->string('nama_lengkap', 255);
            $table->string('jenis_kelamin', 11);
            $table->string('instansi', 255);
            $table->string('status', 255);
            $table->string('alamat', 255);
            $table->string('email', 255);
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewa');
    }
};
