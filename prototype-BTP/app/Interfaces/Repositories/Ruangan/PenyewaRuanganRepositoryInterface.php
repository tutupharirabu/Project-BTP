<?php

namespace App\Interfaces\Repositories\Ruangan;

use App\Models\Ruangan;

interface PenyewaRuanganRepositoryInterface extends BaseRuanganRepositoryInterface
{
  public function getApprovedPeminjamanRuangan(string $idRuangan);
}