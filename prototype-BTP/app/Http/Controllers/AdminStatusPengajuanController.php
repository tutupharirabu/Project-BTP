<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminStatusPengajuanController extends Controller
{
    public function index()
    {
        $dataPeminjaman = Peminjaman::with('ruangan')->get();
        return view('admin.statusPengajuanAdmin', compact('dataPeminjaman'));
    }

    public function update(Request $request, string $id)
    {
        $dataPeminjaman = Peminjaman::find($id);
        $pilih = $request->input('pilihan');

        if($pilih == 'terima') {
            $dataPeminjaman->status = 'Disetujui';
            $dataPeminjaman->ruangan->tersedia = '0';
            $dataPeminjaman->ruangan->save();
            $message = 'Peminjaman diterima!';
        } else if ($pilih == 'tolak') {
            $dataPeminjaman->status = 'Ditolak';
            $message = 'Peminjaman ditolak!';
        }

        // } else if ($pilih == 'tinjau ulang') {
        //     $dataMeminjam->status = 'Meninjau Kembali Pengajuan';
        //     $message = 'Mohon maaf, pengajuan sedang ditinjau kembali!';
        // } else if ($pilih == 'ulang') {
        //     $dataMeminjam->status = 'Sedang Menunggu';
        // }

        $dataPeminjaman->save();

        return redirect('/statusPengajuanAdmin');
    }
}
