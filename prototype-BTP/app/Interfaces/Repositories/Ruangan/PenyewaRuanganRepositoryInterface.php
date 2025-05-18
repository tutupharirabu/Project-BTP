<?php

namespace App\Interfaces\Repositories\Ruangan;

use App\Models\Ruangan;

interface PenyewaRuanganRepositoryInterface
{
  public function getApprovedPeminjamanRuangan(string $idRuangan);
}