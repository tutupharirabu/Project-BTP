<?php

namespace App\Services\Peminjaman\StatusPengajuan;

use InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Interfaces\Repositories\Peminjaman\StatusPengajuan\BaseStatusPengajuanRepositoryInterfaces;
use App\Interfaces\Repositories\Peminjaman\StatusPengajuan\AdminStatusPengajuanRepositoryInterfaces;

class AdminStatusPengajuanService
{
  protected BaseStatusPengajuanRepositoryInterfaces $baseStatusPengajuanRepository;
  protected AdminStatusPengajuanRepositoryInterfaces $adminStatusPengajuanRepository;

  public function __construct(BaseStatusPengajuanRepositoryInterfaces $baseStatusPengajuanRepositoryInterfaces, AdminStatusPengajuanRepositoryInterfaces $adminStatusPengajuanRepositoryInterfaces)
  {
    $this->baseStatusPengajuanRepository = $baseStatusPengajuanRepositoryInterfaces;
    $this->adminStatusPengajuanRepository = $adminStatusPengajuanRepositoryInterfaces;
  }

  public function getAllPeminjaman()
  {
    return $this->baseStatusPengajuanRepository->getAllPeminjaman();
  }

  public function updateStatus(string $id, string $pilihan, string $idUser): void
  {
    $peminjaman = $this->baseStatusPengajuanRepository->getPeminjamanById($id);

    if (!$peminjaman) {
      throw new ModelNotFoundException("Peminjaman tidak ditemukan");
    }

    match ($pilihan) {
      'terima' => $this->adminStatusPengajuanRepository->approvePengajuan($peminjaman, $idUser),
      'tolak' => $this->adminStatusPengajuanRepository->rejectPengajuan($peminjaman, $idUser),
      default => throw new InvalidArgumentException("Pilihan status tidak valid"),
    };
  }

  public function finishPeminjaman(string $id, string $idUser): void
  {
    $peminjaman = $this->baseStatusPengajuanRepository->getPeminjamanById($id);

    if (!$peminjaman) {
      throw new ModelNotFoundException("Peminjaman tidak ditemukan");
    }

    $this->adminStatusPengajuanRepository->completePengajuan($peminjaman, $idUser);
  }

}