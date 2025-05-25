<?php

use App\Enums\StatusPeminjaman;
use App\Enums\Penyewa\StatusPenyewa;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Enums\Database\UsersDatabaseColumn;
use Illuminate\Database\Migrations\Migration;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Enums\Database\PeminjamanDatabaseColumn;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(PeminjamanDatabaseColumn::Peminjaman->value, function (Blueprint $table) {
            $table->uuid(PeminjamanDatabaseColumn::IdPeminjaman->value)->primary();
            $table->string(PeminjamanDatabaseColumn::NamaPenyewa->value, 255);
            $table->enum(PeminjamanDatabaseColumn::StatusPenyewa->value, [StatusPenyewa::Pegawai->value, StatusPenyewa::Mahasiswa->value, StatusPenyewa::Umum->value]);
            $table->string(PeminjamanDatabaseColumn::NomorIndukPenyewa->value,255);
            $table->string(PeminjamanDatabaseColumn::NomorTeleponPenyewa->value,255);
            $table->string(PeminjamanDatabaseColumn::UrlKtp->value)->nullable();
            $table->dateTime(PeminjamanDatabaseColumn::TanggalMulai->value);
            $table->dateTime(PeminjamanDatabaseColumn::TanggalSelesai->value);
            $table->bigInteger(PeminjamanDatabaseColumn::JumlahPeserta->value);
            $table->string(PeminjamanDatabaseColumn::TotalHarga->value, 255);
            $table->enum(PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value, [StatusPeminjaman::Menunggu->value, StatusPeminjaman::Disetujui->value, StatusPeminjaman::Ditolak->value, StatusPeminjaman::Selesai->value]);
            $table->string(PeminjamanDatabaseColumn::KeteranganPenyewaan->value, 255);
            $table->uuid(UsersDatabaseColumn::IdUsers->value)->nullable();
            $table->uuid(RuanganDatabaseColumn::IdRuangan->value);
            $table->foreign(UsersDatabaseColumn::IdUsers->value)->references(UsersDatabaseColumn::IdUsers->value)->on(UsersDatabaseColumn::Users->value)->onDelete('cascade');
            $table->foreign(RuanganDatabaseColumn::IdRuangan->value)->references(RuanganDatabaseColumn::IdRuangan->value)->on(RuanganDatabaseColumn::Ruangan->value)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(PeminjamanDatabaseColumn::Peminjaman->value);
    }
};
