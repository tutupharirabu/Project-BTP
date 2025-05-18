<?php

namespace App\Repositories\Peminjaman\StatusPengajuan;

use App\Models\Peminjaman;
use App\Interfaces\Repositories\Peminjaman\StatusPengajuan\BaseStatusPengajuanRepositoryInterfaces;


class PenyewaStatusPengajuanRepository implements BaseStatusPengajuanRepositoryInterfaces
{
  public function getAllPeminjaman()
  {
    return Peminjaman::with('ruangan')
      ->orderByDesc('created_at')
      ->orderByDesc('updated_at')
      ->get();
  }

  public function getPeminjamanById(string $idPeminjaman): ?Peminjaman
  {
    return Peminjaman::with('ruangan')->findOrFail($idPeminjaman);
  }
}