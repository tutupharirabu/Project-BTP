<?php

namespace App\Http\Controllers;

use App\Models\Meminjam;
use Illuminate\Http\Request;

class AdminPengajuanController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataMeminjam = Meminjam::with(['penyewa', 'barang', 'ruangan', 'meminjam_ruangan', 'meminjam_barang'])->get();

        return view('admin.pengajuan', compact('dataMeminjam'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataMeminjam = Meminjam::find($id);
        $pilih = $request->input('pilihan');

        if($pilih == 'terima') {
            $dataMeminjam->status = 'Diterima';
            $message = 'Peminjaman diterima!';
        } else if ($pilih == 'tolak') {
            $dataMeminjam->status = 'Ditolak';
            $message = 'Peminjaman ditolak!';
        } else if ($pilih == 'tinjau ulang') {
            $dataMeminjam->status = 'Meninjau Kembali Pengajuan';
            $message = 'Mohon maaf, pengajuan sedang ditinjau kembali!';
        } else if ($pilih == 'ulang') {
            $dataMeminjam->status = 'Sedang Menunggu';
        }

        $dataMeminjam->save();

        return redirect('/pengajuan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
