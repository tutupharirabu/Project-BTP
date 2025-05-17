<?php

namespace App\Repositories\Peminjaman\StatusPengajuan;

use App\Models\Peminjaman;
use App\Interfaces\Repositories\Peminjaman\StatusPengajuan\BaseStatusPengajuanRepositoryInterfaces;

class BaseStatusPengajuanRepository implements BaseStatusPengajuanRepositoryInterfaces
{
  public function getAllPeminjaman()
  {
    return Peminjaman::with(['ruangan', 'users'])
      ->orderByDesc('created_at')
      ->orderByDesc('updated_at')
      ->get();
  }

  public function getPeminjamanById(string $idPeminjaman): ?Peminjaman
  {
    return Peminjaman::findOrFail($idPeminjaman);
  }
}