<?php

namespace App\Interfaces\Repositories\Peminjaman\StatusPengajuan;

use App\Models\Peminjaman;
use App\Interfaces\Repositories\Peminjaman\BasePeminjamanRepositoryInterface;

interface BaseStatusPengajuanRepositoryInterface extends BasePeminjamanRepositoryInterface
{
  public function getPeminjamanById(string $idPeminjaman): ?Peminjaman;
}