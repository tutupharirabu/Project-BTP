<?php

namespace App\Repositories\Peminjaman\RiwayatPeminjaman;

use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Enums\Relation\PeminjamanRelasi;
use App\Interfaces\Repositories\Peminjaman\BasePeminjamanRepositoryInterface;
use App\Models\Peminjaman;

class AdminRiwayatPeminjamanRepository implements BasePeminjamanRepositoryInterface
{
  public function getAllPeminjaman()
  {
    return Peminjaman::with(PeminjamanRelasi::Ruangan->value)
      ->orderBy(PeminjamanDatabaseColumn::CreatedAt->value, 'desc')
      ->orderBy(PeminjamanDatabaseColumn::UpdatedAt->value, 'desc')
      ->get();
  }
}