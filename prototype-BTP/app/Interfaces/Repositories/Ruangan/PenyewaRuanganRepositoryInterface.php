<?php

namespace App\Interfaces\Repositories\Ruangan;

use Illuminate\Support\Collection;

interface PenyewaRuanganRepositoryInterface
{
  public function getRuanganByGroupId(string $groupId): Collection;
  public function getApprovedPeminjamanRuangan(string $idRuangan);
  public function getCoworkingWeeklySeatStatus(string $idRuangan, string $tanggalMulai, string $tanggalSelesai): array;
}