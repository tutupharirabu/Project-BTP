<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\Peminjaman;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $dataPeminjaman = Peminjaman::all();
        $dataRuangan = Ruangan::all();

        return view('penyewa.meminjamRuangan', compact('dataPeminjaman', 'dataRuangan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required|string',
            'id_ruangan' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'jumlah' => 'required',
            'keterangan' => 'required',
        ]);

        $tanggal_mulai = $request->input('tanggal_mulai').' '.$request->input('jam_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai').' '.$request->input('jam_selesai');

        $meminjamRuangan = new Peminjaman([
            'nama_peminjam' => $request->input('nama_peminjam'),
            'id_ruangan' => $request->input('id_ruangan'),
            'id_barang' => null,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'jumlah' => $request->input('jumlah'),
            'status' => 'Menunggu',
            'keterangan' => $request->input('keterangan'),
        ]);

        $meminjamRuangan->save();

        return redirect('/dashboardPenyewa')->with('success', 'Daftar Meminjam Ruangan Successfull');

    }

    public function getRuanganDetails(Request $request)
{
    $idRuangan = $request->query('id_ruangan');
    $ruangan = Ruangan::find($idRuangan);

    if ($ruangan) {
        return response()->json([
            'lokasi' => $ruangan->lokasi,
            'harga_ruangan' => $ruangan->harga_ruangan,
        ]);
    } else {
        return response()->json(['error' => 'Ruangan not found'], 404);
    }
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
