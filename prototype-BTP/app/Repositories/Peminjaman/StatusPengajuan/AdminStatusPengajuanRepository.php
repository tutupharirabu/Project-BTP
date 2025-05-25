<?php

namespace App\Repositories\Peminjaman\StatusPengajuan;

use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Enums\StatusPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Support\Collection;
use App\Interfaces\Repositories\Peminjaman\StatusPengajuan\AdminStatusPengajuanRepositoryInterface;

class AdminStatusPengajuanRepository implements AdminStatusPengajuanRepositoryInterface
{
  public function getConflictingBookings(Peminjaman $peminjaman): Collection
  {
    return Peminjaman::where(PeminjamanDatabaseColumn::TanggalMulai->value, '<=', $peminjaman->tanggal_selesai)
      ->where(PeminjamanDatabaseColumn::TanggalSelesai->value, '>=', $peminjaman->tanggal_mulai)
      ->where(PeminjamanDatabaseColumn::IdPeminjaman->value, '!=', $peminjaman->id_peminjaman)
      ->where(RuanganDatabaseColumn::IdRuangan->value, $peminjaman->id_ruangan)
      ->where(PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value, StatusPeminjaman::Menunggu->value)
      ->get();
  }

  public function approvePengajuan(Peminjaman $peminjaman, string $idUser): void
  {
    $conflicts = $this->getConflictingBookings($peminjaman);

    $peminjaman->status = StatusPeminjaman::Disetujui->value;
    $peminjaman->id_users = $idUser;
    $peminjaman->save();

    foreach ($conflicts as $booking) {
      $booking->status = StatusPeminjaman::Ditolak->value;
      $booking->id_users = $idUser;
      $booking->save();
    }
  }

  public function rejectPengajuan(Peminjaman $peminjaman, string $idUser): void
  {
    $peminjaman->status = StatusPeminjaman::Ditolak->value;
    $peminjaman->id_users = $idUser;
    $peminjaman->save();
  }

  public function completePengajuan(Peminjaman $peminjaman, string $idUser): void
  {
    $peminjaman->status = StatusPeminjaman::Selesai->value;
    $peminjaman->id_users = $idUser;
    $peminjaman->save();
  }
}