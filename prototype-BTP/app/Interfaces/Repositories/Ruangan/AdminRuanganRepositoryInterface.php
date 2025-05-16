<?php

namespace App\Interfaces\Repositories\Ruangan;

use App\Models\Ruangan;

interface AdminRuanganRepositoryInterface extends BaseRuanganRepositoryInterface
{
  public function checkRuanganByName(string $namaRuangan): bool;
  public function createRuangan(array $data): Ruangan;
  public function deleteRuangan(Ruangan $ruangan): void;
}