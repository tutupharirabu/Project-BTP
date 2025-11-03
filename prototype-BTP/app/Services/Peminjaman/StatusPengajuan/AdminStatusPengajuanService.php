<?php

namespace App\Services\Peminjaman\StatusPengajuan;

use InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Interfaces\Repositories\Peminjaman\StatusPengajuan\BaseStatusPengajuanRepositoryInterface;
use App\Interfaces\Repositories\Peminjaman\StatusPengajuan\AdminStatusPengajuanRepositoryInterface;

class AdminStatusPengajuanService
{
  protected BaseStatusPengajuanRepositoryInterface $baseStatusPengajuanRepository;
  protected AdminStatusPengajuanRepositoryInterface $adminStatusPengajuanRepository;

  public function __construct(BaseStatusPengajuanRepositoryInterface $baseStatusPengajuanRepositoryInterface, AdminStatusPengajuanRepositoryInterface $adminStatusPengajuanRepositoryInterface)
  {
    $this->baseStatusPengajuanRepository = $baseStatusPengajuanRepositoryInterface;
    $this->adminStatusPengajuanRepository = $adminStatusPengajuanRepositoryInterface;
  }

  public function getAllPeminjaman()
  {
    return $this->baseStatusPengajuanRepository->getAllPeminjaman();
  }

  public function getPeminjamanById(string $id)
  {
    $peminjaman = $this->baseStatusPengajuanRepository->getPeminjamanById($id);

    if (!$peminjaman) {
      throw new ModelNotFoundException("Peminjaman tidak ditemukan");
    }

    return $peminjaman;
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

  public function deletePeminjaman(string $id): void
  {
    $peminjaman = $this->baseStatusPengajuanRepository->getPeminjamanById($id);

    if (!$peminjaman) {
      throw new ModelNotFoundException("Peminjaman tidak ditemukan");
    }

    $this->adminStatusPengajuanRepository->deletePengajuan($peminjaman);
  }

}
