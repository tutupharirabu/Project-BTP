<?php

namespace App\Repositories\Dashboard;

use App\Interfaces\Repositories\Dashboard\DashboardRepositoryInterface;
use App\Models\Peminjaman;

class DashboardRepository implements DashboardRepositoryInterface
{
  public function getDisetujuiOrSelesaiWithRuangan()
  {
    return Peminjaman::with('ruangan')
      ->whereIn('status', ['Disetujui', 'Selesai'])
      ->get();
  }
}