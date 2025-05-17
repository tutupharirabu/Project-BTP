<?php

namespace App\Interfaces\Repositories\Ruangan;

use App\Models\Ruangan;

interface BaseRuanganRepositoryInterface
{
    public function getAllRuangan();
    public function getRuanganById(string $idRuangan): ?Ruangan;
}