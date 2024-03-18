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
        Schema::create('room_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            // $table->unsignedBigInteger('room_id');
            // $table->foreign('room_id')->references('id')->on('rooms');
            $table->string('room_id');
            $table->string('keperluan', 100);
            $table->integer('jumlahPesertaPanitia')->nullable();
            $table->date('borrow_date_start');
            $table->date('borrow_date_end');
            $table->time('jam_mulai');
            $table->time('jam_berakhir');
            $table->string('penanggungjawab', 50)->nullable();
            $table->string('img')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_logs');
    }
};
