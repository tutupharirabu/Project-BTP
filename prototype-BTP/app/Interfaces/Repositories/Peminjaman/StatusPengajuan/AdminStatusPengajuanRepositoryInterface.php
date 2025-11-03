<?php

namespace App\Interfaces\Repositories\Peminjaman\StatusPengajuan;

use App\Models\Peminjaman;
use Illuminate\Support\Collection;

interface AdminStatusPengajuanRepositoryInterface
{
  public function getConflictingBookings(Peminjaman $peminjaman): Collection;
  public function approvePengajuan(Peminjaman $peminjaman, string $idUser): void;
  public function rejectPengajuan(Peminjaman $peminjaman, string $idUser): void;
  public function completePengajuan(Peminjaman $peminjaman, string $idUser): void;
  public function deletePengajuan(Peminjaman $peminjaman): void;
}
