<?php

namespace App\Http\Controllers\Admin\Ruangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Ruangan\AdminRuanganService;
use App\Interfaces\Repositories\AdminRuanganRepositoryInterface;

class AdminRuanganController extends Controller
{
    protected AdminRuanganService $adminRuanganService;
    protected AdminRuanganRepositoryInterface $adminRuanganRepository;

    public function __construct(AdminRuanganService $adminRuanganService, AdminRuanganRepositoryInterface $adminRuanganRepositoryInterface)
    {
        $this->adminRuanganService = $adminRuanganService;
        $this->adminRuanganRepository = $adminRuanganRepositoryInterface;
    }

    public function index()
    {
        $dataRuangan = $this->adminRuanganRepository->getAllRuangan();
        return view('admin.daftarRuanganAdmin', compact('dataRuangan'));
    }

    public function checkRuanganName(Request $request)
    {
        $exists = $this->adminRuanganRepository->checkRuanganByName($request->input('nama_ruangan'));
        return response()->json(['exists' => $exists]);
    }

    public function destroy(string $id)
    {
        $ruangan = $this->adminRuanganRepository->getRuanganById($id);
        $this->adminRuanganRepository->deleteRuangan($ruangan);
        return redirect()->route('ruangan.listRuangan');
    }
}
