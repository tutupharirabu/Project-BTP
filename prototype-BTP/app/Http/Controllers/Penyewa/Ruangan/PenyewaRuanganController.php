<?php

namespace App\Http\Controllers\Penyewa\Ruangan;

use App\Http\Controllers\Controller;
use App\Interfaces\Repositories\Ruangan\BaseRuanganRepositoryInterface;
use App\Services\Ruangan\PenyewaRuanganService;
use App\Interfaces\Repositories\Ruangan\PenyewaRuanganRepositoryInterface;

class PenyewaRuanganController extends Controller
{
    protected PenyewaRuanganService $penyewaRuanganService;
    protected PenyewaRuanganRepositoryInterface $penyewaRuanganRepository;
    protected BaseRuanganRepositoryInterface $baseRuanganRepository;

    public function __construct(PenyewaRuanganService $penyewaRuanganService, PenyewaRuanganRepositoryInterface $penyewaRuanganRepositoryInterface, BaseRuanganRepositoryInterface $baseRuanganRepositoryInterface)
    {
        $this->penyewaRuanganService = $penyewaRuanganService;
        $this->penyewaRuanganRepository = $penyewaRuanganRepositoryInterface;
        $this->baseRuanganRepository = $baseRuanganRepositoryInterface;
    }

    public function index()
    {
        $dataRuangan = $this->baseRuanganRepository->getAllRuangan();
        return view('penyewa.daftarRuanganPenyewa', compact('dataRuangan'));
    }
}
