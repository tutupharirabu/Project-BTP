<?php

namespace App\Repositories\Ruangan;

use App\Interfaces\Repositories\Ruangan\PenyewaRuanganRepositoryInterface;
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
}