<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Enums\Database\GambarDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(GambarDatabaseColumn::Gambar->value, function (Blueprint $table) {
            $table->uuid(GambarDatabaseColumn::IdGambar->value)->primary();
            $table->uuid(RuanganDatabaseColumn::IdRuangan->value);
            $table->foreign(RuanganDatabaseColumn::IdRuangan->value)->references(RuanganDatabaseColumn::IdRuangan->value)->on(RuanganDatabaseColumn::Ruangan->value)->onDelete('cascade');
            $table->string(GambarDatabaseColumn::UrlGambar->value, 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(GambarDatabaseColumn::Gambar->value);
    }
};
