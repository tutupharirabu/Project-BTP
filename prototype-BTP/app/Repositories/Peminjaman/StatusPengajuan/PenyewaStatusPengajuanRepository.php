<?php

namespace App\Repositories\Peminjaman\StatusPengajuan;

use App\Models\Peminjaman;
use App\Enums\Relation\PeminjamanRelasi;
use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Interfaces\Repositories\Peminjaman\StatusPengajuan\BaseStatusPengajuanRepositoryInterface;


class PenyewaStatusPengajuanRepository implements BaseStatusPengajuanRepositoryInterface
{
  public function getAllPeminjaman()
  {
    return Peminjaman::with(PeminjamanRelasi::Ruangan->value)
      ->orderByDesc(PeminjamanDatabaseColumn::CreatedAt->value)
      ->orderByDesc(PeminjamanDatabaseColumn::UpdatedAt->value)
      ->get();
  }

  public function getPeminjamanById(string $idPeminjaman): ?Peminjaman
  {
    return Peminjaman::with(PeminjamanRelasi::Ruangan->value)->findOrFail($idPeminjaman);
  }
}