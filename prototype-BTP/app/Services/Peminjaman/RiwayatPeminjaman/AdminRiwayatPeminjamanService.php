<?php

namespace App\Services\Peminjaman\RiwayatPeminjaman;

use Carbon\Carbon;
use App\Interfaces\Repositories\Peminjaman\BasePeminjamanRepositoryInterface;

class AdminRiwayatPeminjamanService
{
  protected BasePeminjamanRepositoryInterface $adminRiwayatPeminjamanRepository;

  public function __construct(BasePeminjamanRepositoryInterface $basePeminjamanRepositoryInterface)
  {
    $this->adminRiwayatPeminjamanRepository = $basePeminjamanRepositoryInterface;
  }

  public function getRiwayatPeminjaman()
  {
    return $this->adminRiwayatPeminjamanRepository->getAllPeminjaman();
  }

  public function getCSVData(): array
  {
    $data = $this->adminRiwayatPeminjamanRepository->getAllPeminjaman();
    $columns = ['No', 'Nama Peminjam', 'Tanggal Mulai', 'Tanggal Selesai', 'Ruangan', 'Kapasitas'];
    $rows = [];

    foreach ($data as $index => $item) {
      $rows[] = [
        $index + 1,
        $item->nama_peminjam,
        Carbon::parse($item->tanggal_mulai)->format('d-m-y'),
        Carbon::parse($item->tanggal_selesai)->format('d-m-y'),
        $item->ruangan->nama_ruangan ?? '-',
        $item->jumlah
      ];
    }

    return [
      'columns' => $columns,
      'rows' => $rows,
    ];
  }
}