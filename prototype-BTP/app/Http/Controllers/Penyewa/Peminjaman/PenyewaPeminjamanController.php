<?php

namespace App\Http\Controllers\Penyewa\Peminjaman;

use RuntimeException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Peminjaman\PenyewaPeminjamanService;
use App\Http\Requests\Peminjaman\BasePeminjamanRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PenyewaPeminjamanController extends Controller
{
    protected PenyewaPeminjamanService $penyewaPeminjamanService;

    public function __construct(PenyewaPeminjamanService $penyewaPeminjamanService)
    {
        $this->penyewaPeminjamanService = $penyewaPeminjamanService;
    }

    public function index(?string $id = null)
    {
        $formData = $this->penyewaPeminjamanService->getFormData();
        $origin = $id ? 'detailRuangan' : 'dashboard';
        $ruangan = $id ? $this->penyewaPeminjamanService->getDetailRuanganById($id) : null;

        return view('penyewa.meminjamRuangan', [
            'dataPeminjaman' => $formData['dataPeminjaman'],
            'dataRuangan' => $formData['dataRuangan'],
            'origin' => $origin,
            'ruangan' => $ruangan,
        ]);
    }

    public function store(BasePeminjamanRequest $request)
    {
        try {
            $this->penyewaPeminjamanService->handlePeminjaman($request);
            return redirect('/dashboardPenyewa')->with('success', 'Peminjaman berhasil.');
        } catch (RuntimeException $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function getDetailRuangan(Request $request)
    {
        try {
            $ruangan = $this->penyewaPeminjamanService->getDetailRuanganById($request->query('id_ruangan'));
            return response()->json($ruangan);
        } catch (NotFoundHttpException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
