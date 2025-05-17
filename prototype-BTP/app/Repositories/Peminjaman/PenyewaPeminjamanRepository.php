<?php

namespace App\Repositories\Peminjaman;

use App\Models\Peminjaman;
use App\Interfaces\Repositories\Peminjaman\PenyewaPeminjamanRepositoryInterface;

class PenyewaPeminjamanRepository implements PenyewaPeminjamanRepositoryInterface
{
  public function getAllPeminjaman()
  {
    return Peminjaman::all();
  }

  public function createPeminjaman(array $data): Peminjaman
  {
    return Peminjaman::create($data);
  }
}