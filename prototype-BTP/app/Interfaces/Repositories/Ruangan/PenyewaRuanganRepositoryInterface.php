<?php

namespace App\Interfaces\Repositories\Ruangan;

interface PenyewaRuanganRepositoryInterface
{
  public function getApprovedPeminjamanRuangan(string $idRuangan);
}