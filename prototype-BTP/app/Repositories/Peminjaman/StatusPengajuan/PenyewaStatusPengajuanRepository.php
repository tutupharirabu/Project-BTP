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
    $withRuangan = PeminjamanRelasi::Ruangan->value;
    $withSessions = PeminjamanRelasi::Sessions->value;
    $orderByCreatedAt = PeminjamanDatabaseColumn::CreatedAt->value;
    $orderByUpdatedAt = PeminjamanDatabaseColumn::UpdatedAt->value;

    return Peminjaman::with([$withRuangan, $withSessions])
      ->orderByDesc($orderByCreatedAt)
      ->orderByDesc($orderByUpdatedAt)
      ->get();
  }

  public function getPeminjamanById(string $idPeminjaman): ?Peminjaman
  {
    $withRuangan = PeminjamanRelasi::Ruangan->value;
    $withSessions = PeminjamanRelasi::Sessions->value;
    return Peminjaman::with([$withRuangan, $withSessions])->findOrFail($idPeminjaman);
  }
}
