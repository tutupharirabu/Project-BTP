<?php

namespace App\Http\Controllers\Admin\Peminjaman\RiwayatPeminjaman;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Services\Peminjaman\RiwayatPeminjaman\AdminRiwayatPeminjamanService;

class AdminRiwayatPeminjamanController extends Controller
{
    protected AdminRiwayatPeminjamanService $adminRiwayatPeminjamanService;

    public function __construct(AdminRiwayatPeminjamanService $adminRiwayatPeminjamanService)
    {
        $this->adminRiwayatPeminjamanService = $adminRiwayatPeminjamanService;
    }

    public function index()
    {
        $dataPeminjaman = $this->adminRiwayatPeminjamanService->getRiwayatPeminjaman();
        return view('riwayatRuangan', compact('dataPeminjaman'));
    }

    public function downloadCSV()
    {
        $fileName = 'riwayat_peminjaman_btp.csv';
        $csvData = $this->adminRiwayatPeminjamanService->getCSVData();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($csvData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvData['columns']);
            foreach ($csvData['rows'] as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
