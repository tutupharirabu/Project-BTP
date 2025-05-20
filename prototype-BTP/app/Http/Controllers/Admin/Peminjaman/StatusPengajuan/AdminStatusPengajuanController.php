<?php

namespace App\Http\Controllers\Admin\Peminjaman\StatusPengajuan;

use InvalidArgumentException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Peminjaman\StatusPengajuan\AdminStatusPengajuanService;

class AdminStatusPengajuanController extends Controller
{
    protected AdminStatusPengajuanService $adminStatusPengajuanService;

    public function __construct(AdminStatusPengajuanService $adminStatusPengajuanService)
    {
        $this->adminStatusPengajuanService = $adminStatusPengajuanService;
        $this->middleware(function ($request, $next) {
            $this->authorize('access-status-pengajuan');
            return $next($request);
        });
    }

    public function index()
    {
        $dataPeminjaman = $this->adminStatusPengajuanService->getAllPeminjaman();
        return view('admin.statusPengajuanAdmin', compact('dataPeminjaman'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $this->adminStatusPengajuanService->updateStatus(
                $id,
                $request->input('pilihan'),
                Auth::id()
            );

            return redirect('/statusPengajuanAdmin')->with('message', 'Status peminjaman berhasil diperbarui!');
        } catch (ModelNotFoundException $e) {
            return redirect('/statusPengajuanAdmin')->with('error', 'Peminjaman tidak ditemukan!');
        } catch (InvalidArgumentException $e) {
            return redirect('/statusPengajuanAdmin')->with('error', 'Pilihan status tidak valid!');
        }
    }

    public function finish(string $id)
    {
        try {
            $this->adminStatusPengajuanService->finishPeminjaman($id, Auth::id());

            return redirect('/statusPengajuanAdmin')->with('message', 'Peminjaman berhasil diselesaikan!');
        } catch (ModelNotFoundException $e) {
            return redirect('/statusPengajuanAdmin')->with('error', 'Peminjaman tidak ditemukan!');
        }
    }
}
