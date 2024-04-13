<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewa;
use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\Meminjam;

class MeminjamController extends Controller
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
        $dataMeminjam = Meminjam::with(['penyewa', 'barang', 'ruangan'])->get();
        $dataPenyewa = Penyewa::all();
        $dataBarang = Barang::all();
        $dataRuangan = Ruangan::all();

        return view('admin.meminjam', compact('dataMeminjam', 'dataPenyewa', 'dataBarang', 'dataRuangan'));
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
