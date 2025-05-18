<?php

namespace App\Repositories\Ruangan;

use App\Interfaces\Repositories\Ruangan\PenyewaRuanganRepositoryInterface;
use App\Models\Peminjaman;

class PenyewaRuanganRepository implements PenyewaRuanganRepositoryInterface
{
  public function getApprovedPeminjamanRuangan(string $idRuangan)
  {
    return Peminjaman::with('ruangan')
      ->where('id_ruangan', $idRuangan)
      ->whereIn('status', ['Disetujui', 'Selesai'])
      ->get();
  }
}