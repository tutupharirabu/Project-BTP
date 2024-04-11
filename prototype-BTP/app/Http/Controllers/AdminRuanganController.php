<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Storage;

class AdminRuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataRuangan = Ruangan::all();
        return view('admin.ruangan', compact('dataRuangan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataRuangan = Ruangan::all();
        return view('admin.crud.ruangan.adminTambahRuangan', compact('dataRuangan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required',
            'kapasitas_ruangan' => 'required',
            'foto_ruangan' => 'required|image|mimes:jpeg,png,jpg',
            'lokasi' => 'required',
        ]);

        $foto_ruangan_path = $request->file('foto_ruangan')->store('ruangan', 'public');

        $ruangan = new Ruangan([
            'nama_ruangan' => $request->input('nama_ruangan'),
            'kapasitas_ruangan' => $request->input('kapasitas_ruangan'),
            'foto_ruangan' => $foto_ruangan_path,
            'lokasi' => $request->input('lokasi'),
        ]);

        $ruangan->save();
        return redirect()->route('admin.ruangan');
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
