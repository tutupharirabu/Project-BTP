<?php

namespace App\Repositories\Ruangan;

use App\Models\Ruangan;
use Illuminate\Support\Facades\DB;
use App\Interfaces\Repositories\Ruangan\AdminRuanganRepositoryInterface;

class AdminRuanganRepository implements AdminRuanganRepositoryInterface
{
  public function getAllRuangan()
  {
    return Ruangan::with(['gambars', 'users'])
      ->orderBy('created_at', 'desc')
      ->get();
  }

  public function getRuanganById(string $idRuangan): ?Ruangan
  {
    return Ruangan::with('gambars')
      ->where('id_ruangan', $idRuangan)
      ->first();
  }

  public function checkRuanganByName(string $namaRuangan): bool
  {
    return Ruangan::where('nama_ruangan', $namaRuangan)
      ->exists();
  }

  public function createRuangan(array $data): Ruangan
  {
    return Ruangan::create($data);
  }

  public function deleteRuangan(Ruangan $ruangan): void
  {
    DB::table('gambar')
      ->where('id_ruangan', $ruangan->id_ruangan)
      ->delete();
    $ruangan->delete();
  }


}