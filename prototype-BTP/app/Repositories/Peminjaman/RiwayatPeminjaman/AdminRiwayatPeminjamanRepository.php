<?php

namespace App\Repositories\Peminjaman\RiwayatPeminjaman;

use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Enums\Relation\PeminjamanRelasi;
use App\Enums\StatusPeminjaman;
use App\Interfaces\Repositories\Peminjaman\BasePeminjamanRepositoryInterface;
use App\Models\Peminjaman;

class AdminRiwayatPeminjamanRepository implements BasePeminjamanRepositoryInterface
{
  public function getAllPeminjaman()
  {
    $withRuangan = PeminjamanRelasi::Ruangan->value;
    $orderByCreatedAt = PeminjamanDatabaseColumn::CreatedAt->value;
    $orderByUpdatedAt = PeminjamanDatabaseColumn::UpdatedAt->value;
    $withSessions = PeminjamanRelasi::Sessions->value;

    $statusColumn = PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value;
    $allowedStatuses = [
      StatusPeminjaman::Disetujui->value,
      StatusPeminjaman::Selesai->value,
    ];

    return Peminjaman::with([$withRuangan, $withSessions])
      ->whereIn($statusColumn, $allowedStatuses)
      ->orderBy($orderByCreatedAt, 'desc')
      ->orderBy($orderByUpdatedAt, 'desc')
      ->get();
  }
}
