<?php

namespace App\Http\Controllers\Penyewa\Ruangan;

use App\Http\Controllers\Controller;
use App\Services\Ruangan\PenyewaRuanganService;
use App\Interfaces\Repositories\Ruangan\PenyewaRuanganRepositoryInterface;

class PenyewaRuanganController extends Controller
{
    protected PenyewaRuanganService $penyewaRuanganService;
    protected PenyewaRuanganRepositoryInterface $penyewaRuanganRepository;

    public function __construct(PenyewaRuanganService $penyewaRuanganService, PenyewaRuanganRepositoryInterface $penyewaRuanganRepositoryInterface)
    {
        $this->penyewaRuanganService = $penyewaRuanganService;
        $this->penyewaRuanganRepository = $penyewaRuanganRepositoryInterface;
    }

    public function index()
    {
        $dataRuangan = $this->penyewaRuanganRepository->getAllRuangan();
        return view('penyewa.daftarRuanganPenyewa', compact('dataRuangan'));
    }
}
