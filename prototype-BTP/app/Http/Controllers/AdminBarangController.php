<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\Meminjam;
use App\Models\MeminjamBarang;
use App\Models\Mengelola;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataBarang = Barang::all();
        return view('admin.barang', compact('dataBarang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataBarang = Barang::all();
        return view('admin.crud.barang.adminTambahBarang', compact('dataBarang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
            'foto_barang' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $foto_barang_path = $request->file('foto_barang')->store('barang', 'public');

        $barang = new Barang([
            'nama_barang' => $request->input('nama_barang'),
            'jumlah_barang' => $request->input('jumlah_barang'),
            'foto_barang' => $foto_barang_path,
        ]);

        $barang->save();
        return redirect()->route('admin.barang');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_barang)
    {
        $dataBarang = Barang::where('id_barang', $id_barang)->first();

        if(!$dataBarang) {
            abort(404);
        }

        return view('admin.crud.barang.adminDetailBarang', ['dataBarang' => $dataBarang]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_barang)
    {
        $dataBarang = Barang::find($id_barang);
        return view('admin.crud.barang.adminEditBarang', ['dataBarang' => $dataBarang]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_barang)
    {
        $dataBarang = Barang::find($id_barang);
        $request -> validate([
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
        ]);

        $oldfile = $dataBarang->foto_barang;
        $file = request()->file('foto_barang') ? request()->file('foto_barang')->store('barang', 'public') : $oldfile;

        Barang::where('id_barang', $dataBarang->id_barang)->update([
            'nama_barang' => $request['nama_barang'],
            'jumlah_barang' => $request['jumlah_barang'],
            'foto_barang' => $file,
        ]);

        return redirect()->route('admin.barang');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_barang)
    {
        $dataBarang = Barang::with(['meminjam', 'meminjam_barang', 'mengelola'])->where('id_barang', $id_barang)->first();
        $image_name = $dataBarang->foto_barang;
        $image_path = \public_path('storage/' . $dataBarang->foto_barang);

        if(File::exists($image_path)){
            unlink($image_path);
        }

        Barang::destroy($dataBarang->id_barang);
        return redirect()->route('admin.barang');
    }
}
