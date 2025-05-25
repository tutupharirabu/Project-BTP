<?php

namespace App\Repositories\Peminjaman\StatusPengajuan;

use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Enums\Relation\PeminjamanRelasi;
use App\Models\Peminjaman;
use App\Interfaces\Repositories\Peminjaman\StatusPengajuan\BaseStatusPengajuanRepositoryInterface;

class BaseStatusPengajuanRepository implements BaseStatusPengajuanRepositoryInterface
{
  public function getAllPeminjaman()
  {
    return Peminjaman::with([PeminjamanRelasi::Ruangan->value, PeminjamanRelasi::User->value])
      ->orderByDesc(PeminjamanDatabaseColumn::CreatedAt->value)
      ->orderByDesc(PeminjamanDatabaseColumn::UpdatedAt->value)
      ->get();
  }

  public function getPeminjamanById(string $idPeminjaman): ?Peminjaman
  {
    return Peminjaman::findOrFail($idPeminjaman);
  }
}