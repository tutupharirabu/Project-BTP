<?php

namespace App\Services\Peminjaman\StatusPengajuan;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Interfaces\Repositories\Peminjaman\StatusPengajuan\BaseStatusPengajuanRepositoryInterface;

class PenyewaStatusPengajuanService
{
  protected BaseStatusPengajuanRepositoryInterface $penyewaStatusPengajuanRepository;

  public function __construct(BaseStatusPengajuanRepositoryInterface $penyewaStatusPengajuanRepositoryInterface)
  {
    $this->penyewaStatusPengajuanRepository = $penyewaStatusPengajuanRepositoryInterface;
  }

  public function getAllPeminjaman()
  {
    return $this->penyewaStatusPengajuanRepository->getAllPeminjaman();
  }

  public function generateInvoicePdf(string $idPeminjaman)
  {
    $data = $this->penyewaStatusPengajuanRepository->getPeminjamanById($idPeminjaman);

    if (method_exists($data, 'ensureInvoiceNumber')) {
      $data->ensureInvoiceNumber();
      $data->refresh();
    }

    return Pdf::loadView('penyewa.invoices.invoice', compact('data'))
      ->setPaper([0, 0, 595.28, 566.93], 'portrait');
  }
}
