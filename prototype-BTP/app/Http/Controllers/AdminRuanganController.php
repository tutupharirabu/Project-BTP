<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\Meminjam;
use App\Models\MeminjamRuangan;
use App\Models\Pengelola;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
    public function show(string $id_ruangan)
    {
        $dataRuangan = Ruangan::where('id_ruangan', $id_ruangan)->first();

        if(!$dataRuangan){
            abort(404);
        }

        return view('admin.crud.ruangan.adminDetailRuangan', ['dataRuangan' => $dataRuangan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dataRuangan = Ruangan::find($id);
        return view('admin.crud.ruangan.adminEditRuangan', ['dataRuangan' => $dataRuangan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_ruangan)
    {
        $dataRuangan = Ruangan::find($id_ruangan);
        $request->validate([
            'nama_ruangan' => 'required',
            'kapasitas_ruangan' => 'required',
            'foto_ruangan' => 'required|image|mimes:jpeg,png,jpg',
            'lokasi' => 'required',
        ]);

        $file = request()->file('foto_ruangan') ? request()->file('foto_ruangan')->store('ruangan', 'public') : null;

        Ruangan::where('id_ruangan', $dataRuangan->id_ruangan)->update([
            'nama_ruangan' => $request['nama_ruangan'],
            'kapasitas_ruangan' => $request['kapasitas_ruangan'],
            'foto_ruangan' => $file,
            'lokasi' => $request['lokasi'],
        ]);

        return redirect()->route('admin.ruangan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_ruangan)
    {
        $dataRuangan = Ruangan::with(['meminjam', 'meminjam_ruangan', 'pengelola'])->where('id_ruangan', $id_ruangan)->first();
        $image_name = $dataRuangan->foto_ruangan;
        $image_path = \public_path('storage/' . $dataRuangan->foto_ruangan);
        if(File::exists($image_path)){
            unlink($image_path);
        }
        Ruangan::destroy($dataRuangan->id_ruangan);
        return redirect()->route('admin.ruangan');
    }
}
