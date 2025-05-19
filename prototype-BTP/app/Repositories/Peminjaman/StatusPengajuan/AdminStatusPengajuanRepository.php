<?php

namespace App\Repositories\Peminjaman\StatusPengajuan;

use App\Models\Peminjaman;
use Illuminate\Support\Collection;
use App\Interfaces\Repositories\Peminjaman\StatusPengajuan\AdminStatusPengajuanRepositoryInterface;

class AdminStatusPengajuanRepository implements AdminStatusPengajuanRepositoryInterface
{
  public function getConflictingBookings(Peminjaman $peminjaman): Collection
  {
    return Peminjaman::where('tanggal_mulai', '<=', $peminjaman->tanggal_selesai)
      ->where('tanggal_selesai', '>=', $peminjaman->tanggal_mulai)
      ->where('id_peminjaman', '!=', $peminjaman->id_peminjaman)
      ->where('id_ruangan', $peminjaman->id_ruangan)
      ->where('status', 'Menunggu')
      ->get();
  }

  public function approvePengajuan(Peminjaman $peminjaman, string $idUser): void
  {
    $conflicts = $this->getConflictingBookings($peminjaman);

    $peminjaman->status = 'Disetujui';
    $peminjaman->ruangan->status = 'Digunakan';
    $peminjaman->id_users = $idUser;

    $peminjaman->ruangan->save();
    $peminjaman->save();

    foreach ($conflicts as $booking) {
      $booking->status = 'Ditolak';
      $booking->id_users = $idUser;
      $booking->save();
    }
  }

  public function rejectPengajuan(Peminjaman $peminjaman, string $idUser): void
  {
    $peminjaman->status = 'Ditolak';
    $peminjaman->id_users = $idUser;
    $peminjaman->save();
  }

  public function completePengajuan(Peminjaman $peminjaman, string $idUser): void
  {
    $peminjaman->status = 'Selesai';
    $peminjaman->ruangan->status = 'Tersedia';
    $peminjaman->id_users = $idUser;

    $peminjaman->ruangan->save();
    $peminjaman->save();
  }
}