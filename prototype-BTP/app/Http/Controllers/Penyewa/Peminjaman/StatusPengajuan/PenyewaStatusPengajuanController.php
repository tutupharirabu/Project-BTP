<?php

namespace App\Http\Controllers\Penyewa\Peminjaman\StatusPengajuan;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Peminjaman\StatusPengajuan\PenyewaStatusPengajuanService;

class PenyewaStatusPengajuanController extends Controller
{
    protected PenyewaStatusPengajuanService $penyewaStatusPengajuanService;

    public function __construct(PenyewaStatusPengajuanService $penyewaStatusPengajuanService)
    {
        $this->penyewaStatusPengajuanService = $penyewaStatusPengajuanService;
    }

    public function index()
    {
        $dataPeminjaman = $this->penyewaStatusPengajuanService->getAllPeminjaman();
        return view('penyewa.statusPenyewa', compact('dataPeminjaman')); 
    }

    public function generateInvoice($id)
    {
        try {
            $pdf = $this->penyewaStatusPengajuanService->generateInvoicePdf($id);
            return $pdf->stream('invoice.pdf');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat invoice.');
        }
    }
}
