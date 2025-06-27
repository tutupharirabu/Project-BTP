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
    $gambarsRelasi = RuanganRelasi::Gambars->value;
    $userRelasi = RuanganRelasi::User->value;
    $createdAtColumn = RuanganDatabaseColumn::CreatedAt->value;
    return Ruangan::with([$gambarsRelasi, $userRelasi])
      ->orderBy($createdAtColumn, 'desc')
      ->get();
  }

  public function getRuanganById(string $idRuangan): ?Ruangan
  {
    $gambarsRelasi = RuanganRelasi::Gambars->value;
    $idRuanganColumn = RuanganDatabaseColumn::IdRuangan->value;
    return Ruangan::with($gambarsRelasi)
      ->where($idRuanganColumn, $idRuangan)
      ->first();
  }

  public function checkRuanganByName(string $namaRuangan): bool
  {
    $namaRuanganColumn = RuanganDatabaseColumn::NamaRuangan->value;
    return Ruangan::where($namaRuanganColumn, $namaRuangan)
      ->exists();
  }

  public function getGroupIdByCoreNamaRuangan(string $coreNama): ?string
  {
    // Gunakan LIKE biar fleksibel
    $namaRuanganColumn = RuanganDatabaseColumn::NamaRuangan->value;
    $ruangan = Ruangan::where($namaRuanganColumn, 'LIKE', $coreNama . '%')->first();
    return $ruangan ? $ruangan->group_id_ruangan : null;
  }

  public function createRuangan(array $data): Ruangan
  {
    return Ruangan::create($data);
  }

  public function deleteRuangan(Ruangan $ruangan): void
  {
    $gambarTable = GambarDatabaseColumn::Gambar->value;
    $idRuanganColumn = RuanganDatabaseColumn::IdRuangan->value;
    DB::table($gambarTable)
      ->where($idRuanganColumn, $ruangan->id_ruangan)
      ->delete();
    $ruangan->delete();
  }
}