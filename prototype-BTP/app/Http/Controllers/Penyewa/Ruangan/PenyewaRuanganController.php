<?php

namespace App\Http\Controllers\Penyewa\Ruangan;

use App\Http\Controllers\Controller;
use App\Interfaces\Repositories\Ruangan\PenyewaRuanganRepositoryInterface;
use Illuminate\Http\Request;

class PenyewaRuanganController extends Controller
{
    protected PenyewaRuanganRepositoryInterface $penyewaRuanganRepository;

    public function __construct(PenyewaRuanganRepositoryInterface $penyewaRuanganRepositoryInterface)
    {
        $this->penyewaRuanganRepository = $penyewaRuanganRepositoryInterface;
    }

    public function index()
    {
        $dataRuangan = $this->penyewaRuanganRepository->getAllRuangan();
        return view('penyewa.daftarRuanganPenyewa', compact('dataRuangan'));
    }
}
