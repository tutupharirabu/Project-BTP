<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\Gambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminStatusRuanganController extends Controller
{
    public function index()
    {
        $dataRuangan = Ruangan::all();
        return view('admin.daftarRuanganAdmin',compact('dataRuangan'));
    }

    public function getEvents()
    {
        // $schedules = Schedule::all();
        // return response()->json($schedules);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tambahRuanganAdmin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string',
            'kapasitas_ruangan' => 'required',
            'lokasi' => 'required',
            'harga_ruangan' => 'required',
            'tersedia' => 'required',
            'status' => 'required',
            'url' => 'required|array',
            'url.*' => 'required|image'
        ]);

        $ruangan = Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan,
            'kapasitas_ruangan' => $request->kapasitas_ruangan,
            'lokasi' => $request->lokasi,
            'harga_ruangan' => $request->harga_ruangan,
            'tersedia' => $request->tersedia,
            'status' => $request->status,
        ]);

        foreach($request->file('url') as $file){
            $path = $file->store('ruangan', 'public');
            Gambar::create([
                'id_ruangan' => $ruangan->id_ruangan,
                'url' => $path
            ]);
        }

        return redirect('/statusRuanganPenyewa')->with('success', 'Ruangan dan Gambar berhasil ditambahkan');
    }

    public function dropzone(Request $req){
        $image = $req->file('file');
        $imageName = time().rand(1,100).'.'.$image->extension();
        $image->move(public_path('image'),$imageName);
        return response()->json(['success'=>$imageName]);
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
        $dataRuangan = Ruangan::with('gambar')->find($id);
        return view('admin.editRuanganAdmin', ['dataRuangan' => $dataRuangan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataRuangan = Ruangan::find($id);

        $request->validate([
            'nama_ruangan' => 'required|string',
            'kapasitas_ruangan' => 'required',
            'lokasi' => 'required',
            'harga_ruangan' => 'required',
            'tersedia' => 'required',
            'status' => 'required',
            'url' => 'required|array',
            'url.*' => 'required|image'
        ]);

        Ruangan::where('id_ruangan', $dataRuangan->id_ruangan)->update([
            'nama_ruangan' => $request['nama_ruangan'],
            'kapasitas_ruangan' => $request['kapasitas_ruangan'],
            'lokasi' => $request['lokasi'],
            'harga_ruangan' => $request['harga_ruangan'],
            'tersedia' => $request['tersedia'],
            'status' => $request['status'],
        ]);

        if ($request->hasFile('url')) {
            // Hapus gambar lama
            foreach ($dataRuangan->gambar as $gambar) {
                Storage::delete('public/' . $gambar->url);
                $gambar->delete();
            }

            // Tambahkan gambar baru
            foreach ($request->file('url') as $file) {
                $path = $file->store('ruangan', 'public');
                Gambar::create([
                    'id_ruangan' => $dataRuangan->id_ruangan,
                    'url' => $path
                ]);
            }
        }

        return redirect()->route('statusRuangan')->with('success', 'Ruangan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Ruangan::find($id);

        if ($data) {
            // Retrieve all related gambar records
            $relatedGambars = Gambar::where('id_ruangan', $id)->get();

            // Loop through each gambar record
            foreach ($relatedGambars as $relatedGambar) {
                $image_path = public_path('storage/' . $relatedGambar->url);

                // Check if the image file exists and delete it
                if (File::exists($image_path)) {
                    unlink($image_path);
                }

                // Delete the gambar record
                $relatedGambar->delete();
            }

            // Now delete the ruangan record
            $data->delete();
        }

        return redirect()->route('admin.status');
    }
}
