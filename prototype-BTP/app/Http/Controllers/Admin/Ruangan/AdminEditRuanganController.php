<?php

namespace App\Http\Controllers\Admin\Ruangan;

use App\Http\Requests\UpdateRuanganRequest;
use App\Http\Controllers\Admin\Ruangan\AdminRuanganController;

class AdminEditRuanganController extends AdminRuanganController
{
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
