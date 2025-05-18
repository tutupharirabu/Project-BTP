<?php

namespace App\Services\Peminjaman\StatusPengajuan;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Interfaces\Repositories\Peminjaman\StatusPengajuan\BaseStatusPengajuanRepositoryInterfaces;

class PenyewaStatusPengajuanService
{
  protected BaseStatusPengajuanRepositoryInterfaces $penyewaStatusPengajuanRepository;

  public function __construct(BaseStatusPengajuanRepositoryInterfaces $penyewaStatusPengajuanRepositoryInterfaces)
  {
    $this->penyewaStatusPengajuanRepository = $penyewaStatusPengajuanRepositoryInterfaces;
  }

  public function getAllPeminjaman()
  {
    return $this->penyewaStatusPengajuanRepository->getAllPeminjaman();
  }

  public function generateInvoicePdf(string $idPeminjaman)
  {
    $data = $this->penyewaStatusPengajuanRepository->getPeminjamanById($idPeminjaman);

    return Pdf::loadView('penyewa.invoices.invoice', compact('data'))
      ->setPaper([0, 0, 595.28, 566.93], 'portrait');
  }
}