<?php

namespace App\Repositories\Peminjaman\RiwayatPeminjaman;

use App\Interfaces\Repositories\Peminjaman\BasePeminjamanRepositoryInterface;
use App\Models\Peminjaman;

class AdminRiwayatPeminjamanRepository implements BasePeminjamanRepositoryInterface
{
  public function getAllPeminjaman()
  {
    return Peminjaman::with('ruangan')
      ->orderBy('created_at', 'desc')
      ->orderBy('updated_at', 'desc')
      ->get();
  }
}