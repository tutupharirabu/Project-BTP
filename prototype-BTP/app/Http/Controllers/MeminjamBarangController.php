<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penyewa;
use App\Models\Meminjam;
use Illuminate\Http\Request;
use App\Models\MeminjamBarang;

class MeminjamBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('penyewa.meminjamBarang');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataMeminjamBarang = MeminjamBarang::with(['penyewa', 'barang']);
        $dataPenyewa = Penyewa::all();
        $dataBarang = Barang::all();

        return view('penyewa.meminjamBarang', compact('dataMeminjamBarang', 'dataPenyewa', 'dataBarang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_peminjaman' => 'required',
            'tanggal_selesai' => 'required',
            'jumlah_barang' => 'required|numeric',
            'id_penyewa' => 'required',
            'id_barang' => 'required',
        ]);

        $jumlah_barang = $request->input('jumlah_barang');

        $barang = Barang::findOrFail($request->input('id_barang'));
        if ($jumlah_barang > $barang->jumlah_barang) {
            return redirect()->back()->with('error', 'Jumlah barang yang diminta melebihi stok yang tersedia.');
        }

        $meminjamBarang = new MeminjamBarang();
        $meminjamBarang->tanggal_peminjaman = $request->input('tanggal_peminjaman');
        $meminjamBarang->tanggal_selesai = $request->input('tanggal_selesai');
        $meminjamBarang->jumlah_barang = $jumlah_barang; // Gunakan nilai input dari pengguna
        $meminjamBarang->id_penyewa = $request->input('id_penyewa');
        $meminjamBarang->id_barang = $request->input('id_barang');

        $barang->jumlah_barang -= $jumlah_barang;
        $barang->save();

        $meminjamBarang->save();

        $simpanBarang = new Meminjam();
        $simpanBarang->tanggal_peminjaman = $request->input('tanggal_peminjaman');
        $simpanBarang->tanggal_selesai = $request->input('tanggal_selesai');
        $simpanBarang->jumlah_barang = $jumlah_barang; // Gunakan nilai input dari pengguna
        $simpanBarang->id_penyewa = $request->input('id_penyewa');
        $simpanBarang->id_barang = $request->input('id_barang');
        $simpanBarang->id_meminjamBarang = $meminjamBarang->id_meminjamBarang;

        $simpanBarang->save();

        return redirect('/daftarMeminjamBarang')->with('success', 'Daftar Meminjam Barang Successfull');
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
