<?php

namespace App\Repositories\Ruangan;

use App\Models\Ruangan;
use App\Interfaces\Repositories\Ruangan\BaseRuanganRepositoryInterface;

class BaseRuanganRepository implements BaseRuanganRepositoryInterface
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