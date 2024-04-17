<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use App\Models\Ruangan;
use App\Models\Meminjam;
use Illuminate\Http\Request;
use App\Models\MeminjamRuangan;

class MeminjamRuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataMeminjamRuangan = MeminjamRuangan::with(['penyewa', 'ruangan'])->get();
        $dataPenyewa = Penyewa::all();
        $dataRuangan = Ruangan::all();

        return view('penyewa.meminjamRuangan', compact('dataMeminjamRuangan', 'dataPenyewa', 'dataRuangan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_peminjaman' => 'required',
            'tanggal_selesai' => 'required',
            'jumlah_pengguna' => 'required',
            'id_penyewa' => 'required',
            'id_ruangan' => 'required',
        ]);

        $meminjamRuangan = new MeminjamRuangan([
            'tanggal_peminjaman' => $request->input('tanggal_peminjaman'),
            'tanggal_selesai' => $request->input('tanggal_selesai'),
            'jumlah_pengguna' => $request->input('jumlah_pengguna'),
            'id_penyewa' => $request->input('id_penyewa'),
            'id_ruangan' => $request->input('id_ruangan'),
        ]);

        $meminjamRuangan->save();

        $simpanRuangan = new Meminjam([
            'tanggal_peminjaman' => $request->input('tanggal_peminjaman'),
            'tanggal_selesai' => $request->input('tanggal_selesai'),
            'jumlah_pengguna' => $request->input('jumlah_pengguna'),
            'id_penyewa' => $request->input('id_penyewa'),
            'id_ruangan' => $request->input('id_ruangan'),
        ]);

        $simpanRuangan->id_meminjamRuangan = $meminjamRuangan->id_meminjamRuangan;
        $simpanRuangan->save();

        return redirect('/daftarMeminjamRuangan')->with('success', 'Daftar Meminjam Ruangan Successfull');

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
