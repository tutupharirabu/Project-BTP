<?php

namespace App\Interfaces\Repositories;

use App\Models\Ruangan;

interface AdminRuanganRepositoryInterface
{
    public function getAllRuangan();
    public function getRuanganById(string $idRuangan): ?Ruangan;
    public function checkRuanganByName(string $namaRuangan): bool;
    public function createRuangan(array $data): Ruangan;
    public function deleteRuangan(Ruangan $ruangan): void;
}