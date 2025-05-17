<?php

namespace App\Interfaces\Repositories\Peminjaman;

use App\Models\Peminjaman;

interface PenyewaPeminjamanRepositoryInterface extends BasePeminjamanRepositoryInterface
{
  public function createPeminjaman(array $data): Peminjaman;
}