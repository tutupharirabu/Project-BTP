<?php

namespace App\Http\Controllers\Admin\Ruangan;

use App\Enums\Database\RuanganDatabaseColumn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Ruangan\AdminRuanganService;
use App\Interfaces\Repositories\Ruangan\AdminRuanganRepositoryInterface;

class AdminRuanganController extends Controller
{
    protected AdminRuanganService $adminRuanganService;
    protected AdminRuanganRepositoryInterface $adminRuanganRepository;

    public function __construct(AdminRuanganService $adminRuanganService, AdminRuanganRepositoryInterface $adminRuanganRepositoryInterface)
    {
        $this->adminRuanganService = $adminRuanganService;
        $this->adminRuanganRepository = $adminRuanganRepositoryInterface;
        $this->middleware(function ($request, $next) {
            $this->authorize('access-ruangan');
            return $next($request);
        });
    }

    public function index()
    {
        $dataRuangan = $this->adminRuanganRepository->getAllRuangan();
        return view('admin.daftarRuanganAdmin', compact('dataRuangan'));
    }

    public function checkRuanganName(Request $request)
    {
        $namaRuanganColumn = RuanganDatabaseColumn::NamaRuangan->value;
        $exists = $this->adminRuanganRepository->checkRuanganByName($request->input($namaRuanganColumn));
        return response()->json(['exists' => $exists]);
    }

    public function getGroupId(Request $request)
    {
        $namaRuanganColumn = RuanganDatabaseColumn::NamaRuangan->value;
        $groupIdColumn = RuanganDatabaseColumn::GroupIdRuangan->value;

        $nama = $request->input($namaRuanganColumn);
        $groupId = $this->adminRuanganRepository->getGroupIdByCoreNamaRuangan($nama);
        return response()->json([$groupIdColumn => $groupId]);
    }

    public function destroy(string $id)
    {
        $ruangan = $this->adminRuanganRepository->getRuanganById($id);
        $this->adminRuanganRepository->deleteRuangan($ruangan);
        return redirect()->route('ruangan.listRuangan');
    }
}
