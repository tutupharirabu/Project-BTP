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
    $statusMenunggu = StatusPeminjaman::Menunggu->value;

    return Peminjaman::where(PeminjamanDatabaseColumn::TanggalMulai->value, '<=', $peminjaman->tanggal_selesai)
      ->where(PeminjamanDatabaseColumn::TanggalSelesai->value, '>=', $peminjaman->tanggal_mulai)
      ->where(PeminjamanDatabaseColumn::IdPeminjaman->value, '!=', $peminjaman->id_peminjaman)
      ->where(RuanganDatabaseColumn::IdRuangan->value, $peminjaman->id_ruangan)
      ->where(PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value, $statusMenunggu)
      ->get();
  }

  public function approvePengajuan(Peminjaman $peminjaman, string $idUser): void
  {
    $statusDisetujui = StatusPeminjaman::Disetujui->value;
    $statusDitolak = StatusPeminjaman::Ditolak->value;

    $conflicts = $this->getConflictingBookings($peminjaman);

    $peminjaman->status = $statusDisetujui;
    $peminjaman->id_users = $idUser;
    $peminjaman->save();

    foreach ($conflicts as $booking) {
      $booking->status = $statusDitolak;
      $booking->id_users = $idUser;
      $booking->save();
    }
  }

  public function rejectPengajuan(Peminjaman $peminjaman, string $idUser): void
  {
    $statusDitolak = StatusPeminjaman::Ditolak->value;

    $peminjaman->status = $statusDitolak;
    $peminjaman->id_users = $idUser;
    $peminjaman->save();
  }

  public function completePengajuan(Peminjaman $peminjaman, string $idUser): void
  {
    $statusSelesai = StatusPeminjaman::Selesai->value;

    $peminjaman->status = $statusSelesai;
    $peminjaman->id_users = $idUser;
    $peminjaman->save();
  }
}