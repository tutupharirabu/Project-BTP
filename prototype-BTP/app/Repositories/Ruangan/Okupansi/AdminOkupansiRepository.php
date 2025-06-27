<?php

namespace App\Repositories\Ruangan\Okupansi;

use Carbon\Carbon;
use App\Models\Peminjaman;
use App\Enums\StatusPeminjaman;
use Illuminate\Support\Collection;
use App\Enums\Relation\PeminjamanRelasi;
use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Interfaces\Repositories\Ruangan\Okupansi\AdminOkupansiRepositoryInterface;

class AdminOkupansiRepository implements AdminOkupansiRepositoryInterface
{
  public function getPeminjamanByMonth(Carbon $start, Carbon $end): Collection
  {
    $relation = PeminjamanRelasi::Ruangan->value;
    $statusDisetujui = StatusPeminjaman::Disetujui->value;
    $statusSelesai = StatusPeminjaman::Selesai->value;

    return Peminjaman::with($relation)
      ->whereIn(PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value, [$statusDisetujui, $statusSelesai])
      ->whereBetween(PeminjamanDatabaseColumn::TanggalMulai->value, [$start, $end])
      ->get();
  }
}