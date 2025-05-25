<?php

namespace App\Repositories\Ruangan;

use App\Enums\Database\GambarDatabaseColumn;
use App\Models\Ruangan;
use Illuminate\Support\Facades\DB;
use App\Enums\Relation\RuanganRelasi;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Interfaces\Repositories\Ruangan\AdminRuanganRepositoryInterface;

class AdminRuanganRepository implements AdminRuanganRepositoryInterface
{
  public function getAllRuangan()
  {
    return Ruangan::with([RuanganRelasi::Gambars->value, RuanganRelasi::User->value])
      ->orderBy(RuanganDatabaseColumn::CreatedAt->value, 'desc')
      ->get();
  }

  public function getRuanganById(string $idRuangan): ?Ruangan
  {
    return Ruangan::with(RuanganRelasi::Gambars->value)
      ->where(RuanganDatabaseColumn::IdRuangan->value, $idRuangan)
      ->first();
  }

  public function checkRuanganByName(string $namaRuangan): bool
  {
    return Ruangan::where(RuanganDatabaseColumn::NamaRuangan->value, $namaRuangan)
      ->exists();
  }

  public function getGroupIdByCoreNamaRuangan(string $coreNama): ?string
  {
    // Gunakan LIKE biar fleksibel
    $ruangan = Ruangan::where(RuanganDatabaseColumn::NamaRuangan->value, 'LIKE', $coreNama . '%')->first();
    return $ruangan ? $ruangan->group_id_ruangan : null;
  }

  public function createRuangan(array $data): Ruangan
  {
    return Ruangan::create($data);
  }

  public function deleteRuangan(Ruangan $ruangan): void
  {
    DB::table(GambarDatabaseColumn::Gambar->value)
      ->where(RuanganDatabaseColumn::IdRuangan->value, $ruangan->id_ruangan)
      ->delete();
    $ruangan->delete();
  }
}