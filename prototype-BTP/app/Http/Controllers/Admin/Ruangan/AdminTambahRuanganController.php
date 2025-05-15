<?php

namespace App\Http\Controllers\Admin\Ruangan;

use App\Http\Requests\StoreRuanganRequest;
use App\Http\Controllers\Admin\Ruangan\AdminRuanganController;

class AdminTambahRuanganController extends AdminRuanganController
{
    public function index()
    {
        return view('admin.crud.tambahRuanganAdmin');
    }

    public function store(StoreRuanganRequest $request)
    {
        ini_set('max_execution_time', 300);
        $this->adminRuanganService->storeRuangan($request);
        return redirect('/daftarRuanganAdmin')->with('success', 'Ruangan dan Gambar berhasil ditambahkan');
    }
}
