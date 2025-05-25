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
    return Peminjaman::with(PeminjamanRelasi::Ruangan->value)
      ->whereIn(PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value, [StatusPeminjaman::Disetujui->value, StatusPeminjaman::Selesai->value])
      ->whereBetween(PeminjamanDatabaseColumn::TanggalMulai->value, [$start, $end])
      ->get();
  }
}