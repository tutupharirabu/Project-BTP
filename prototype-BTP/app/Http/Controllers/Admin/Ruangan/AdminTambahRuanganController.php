<?php

namespace App\Http\Controllers\Admin\Ruangan;

use App\Services\Ruangan\AdminRuanganService;
use App\Http\Requests\Ruangan\StoreRuanganRequest;
use App\Http\Controllers\Admin\Ruangan\AdminRuanganController;
use App\Interfaces\Repositories\Ruangan\AdminRuanganRepositoryInterface;

class AdminTambahRuanganController extends AdminRuanganController
{
    public function __construct(AdminRuanganService $adminRuanganService, AdminRuanganRepositoryInterface $adminRuanganRepositoryInterface)
    {
        parent::__construct($adminRuanganService, $adminRuanganRepositoryInterface);
        $this->middleware(function ($request, $next) {
            $this->authorize('access-ruangan');
            return $next($request);
        });
    }

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
