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
    $withRuangan = PeminjamanRelasi::Ruangan->value;
    $withUser = PeminjamanRelasi::User->value;
    $orderByCreatedAt = PeminjamanDatabaseColumn::CreatedAt->value;
    $orderByUpdatedAt = PeminjamanDatabaseColumn::UpdatedAt->value;
    $withSessions = PeminjamanRelasi::Sessions->value;

    return Peminjaman::with([$withRuangan, $withUser, $withSessions])
      ->orderByDesc($orderByCreatedAt)
      ->orderByDesc($orderByUpdatedAt)
      ->get();
  }

  public function getPeminjamanById(string $idPeminjaman): ?Peminjaman
  {
    $withRuangan = PeminjamanRelasi::Ruangan->value;
    $withUser = PeminjamanRelasi::User->value;
    $withSessions = PeminjamanRelasi::Sessions->value;

    return Peminjaman::with([$withRuangan, $withUser, $withSessions])->findOrFail($idPeminjaman);
  }
}
