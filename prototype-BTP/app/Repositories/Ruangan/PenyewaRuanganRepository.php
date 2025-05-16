<?php

namespace App\Repositories\Ruangan;

use App\Interfaces\Repositories\Ruangan\PenyewaRuanganRepositoryInterface;
use App\Models\Peminjaman;
use App\Models\Ruangan;

class PenyewaRuanganRepository implements PenyewaRuanganRepositoryInterface
{
  public function getAllRuangan()
  {
    return Ruangan::all();
  }

  public function getRuanganById(string $idRuangan): ?Ruangan
  {
    return Ruangan::findOrFail($idRuangan);
  }

  public function getApprovedPeminjamanRuangan(string $idRuangan)
  {
    \Log::info('Query getApprovedPeminjamanByRuangan', [
      'id_ruangan' => $idRuangan,
      'data' => Peminjaman::where('id_ruangan', $idRuangan)->pluck('status')->toArray()
    ]);
    return Peminjaman::with('ruangan')
      ->where('id_ruangan', $idRuangan)
      ->whereIn('status', ['Disetujui', 'Selesai'])
      ->get();
  }
}