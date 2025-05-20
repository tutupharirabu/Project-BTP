<?php

namespace App\Http\Controllers\Admin\Ruangan;

use App\Services\Ruangan\AdminRuanganService;
use App\Http\Requests\Ruangan\UpdateRuanganRequest;
use App\Http\Controllers\Admin\Ruangan\AdminRuanganController;
use App\Interfaces\Repositories\Ruangan\AdminRuanganRepositoryInterface;

class AdminEditRuanganController extends AdminRuanganController
{
    public function __construct(AdminRuanganService $adminRuanganService, AdminRuanganRepositoryInterface $adminRuanganRepositoryInterface)
    {
        parent::__construct($adminRuanganService, $adminRuanganRepositoryInterface);
        $this->middleware(function ($request, $next) {
            $this->authorize('access-ruangan');
            return $next($request);
        });
    }

    public function edit(string $id)
    {
        $dataRuanganEdit = $this->adminRuanganRepository->getRuanganById($id);
        return view('admin.crud.editRuanganAdmin', compact('dataRuanganEdit'));
    }

    public function update(UpdateRuanganRequest $request, string $id)
    {
        ini_set('max_execution_time', 300);
        $dataRuanganEdit = $this->adminRuanganRepository->getRuanganById($id);
        $this->adminRuanganService->updateRuangan($dataRuanganEdit, $request);
        return redirect()->route('ruangan.listRuangan')->with('success', 'Ruangan berhasil diubah~');
    }
}
