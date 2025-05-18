<?php

namespace App\Repositories\Ruangan\Okupansi;

use Carbon\Carbon;
use App\Models\Peminjaman;
use Illuminate\Support\Collection;
use App\Interfaces\Repositories\Ruangan\Okupansi\AdminOkupansiRepositoryInterface;

class AdminOkupansiRepository implements AdminOkupansiRepositoryInterface
{
  public function getPeminjamanByMonth(Carbon $start, Carbon $end): Collection
  {
    return Peminjaman::with('ruangan')
      ->whereIn('status', ['Disetujui', 'Selesai'])
      ->whereBetween('tanggal_mulai', [$start, $end])
      ->get();
  }
}