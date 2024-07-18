<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RiwayatController extends Controller
{
    public function index()
    {
        $dataPeminjaman = Peminjaman::with('ruangan')->orderBy('tanggal_mulai', 'asc')->paginate(10);
        return view('riwayatRuangan', compact('dataPeminjaman'));
    }

    public function downloadCSV()
    {
        $fileName = 'riwayat_peminjaman_btp.csv';
        $peminjamanData = Peminjaman::with('ruangan')->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = ['No', 'Nama Peminjam', 'Tanggal Mulai', 'Tanggal Selesai', 'Ruangan', 'Kapasitas'];

        $callback = function() use($peminjamanData, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($peminjamanData as $index => $data) {
                $row = [
                    $index + 1,
                    $data->nama_peminjam,
                    Carbon::parse($data->tanggal_mulai)->format('d-m-y'),
                    Carbon::parse($data->tanggal_selesai)->format('d-m-y'),
                    $data->ruangan->nama_ruangan,
                    $data->jumlah
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
