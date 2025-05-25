<?php

namespace App\Repositories\Dashboard;

use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Enums\Relation\PeminjamanRelasi;
use App\Enums\StatusPeminjaman;
use App\Interfaces\Repositories\Dashboard\DashboardRepositoryInterface;
use App\Models\Peminjaman;

class DashboardRepository implements DashboardRepositoryInterface
{
  public function getDisetujuiOrSelesaiWithRuangan()
  {
    return Peminjaman::with(PeminjamanRelasi::Ruangan->value)
      ->whereIn(PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value, [StatusPeminjaman::Disetujui->value, StatusPeminjaman::Selesai->value])
      ->get();
  }
}