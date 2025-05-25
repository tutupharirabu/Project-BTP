<?php

use App\Enums\StatusRuangan;
use App\Enums\Penyewa\SatuanPenyewa;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Enums\Database\UsersDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(RuanganDatabaseColumn::Ruangan->value, function (Blueprint $table) {
            $table->uuid(RuanganDatabaseColumn::GroupIdRuangan->value);
            $table->uuid(RuanganDatabaseColumn::IdRuangan->value)->primary();
            $table->string(RuanganDatabaseColumn::NamaRuangan->value, 255);
            // $table->string('ukuran', 255);
            $table->bigInteger(RuanganDatabaseColumn::KapasitasMinimal->value);
            $table->bigInteger(RuanganDatabaseColumn::KapasitasMaksimal->value);
            $table->enum(RuanganDatabaseColumn::SatuanPenyewaanRuangan->value, [SatuanPenyewa::SeatPerBulan->value, SatuanPenyewa::SeatPerHari->value, SatuanPenyewa::Halfday->value]);
            $table->string(RuanganDatabaseColumn::LokasiRuangan->value, 255);
            $table->string(RuanganDatabaseColumn::HargaRuangan->value, 255);
            // $table->boolean('tersedia');
            $table->string(RuanganDatabaseColumn::KeteranganRuangan->value, 255);
            $table->enum(RuanganDatabaseColumn::StatusRuangan->value, [StatusRuangan::Penuh->value, StatusRuangan::Tersedia->value, StatusRuangan::Digunakan->value]);
            $table->uuid(UsersDatabaseColumn::IdUsers->value);
            $table->foreign(UsersDatabaseColumn::IdUsers->value)->references(UsersDatabaseColumn::IdUsers->value)->on(UsersDatabaseColumn::Users->value)->nullable()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(RuanganDatabaseColumn::Ruangan->value);
    }
};
