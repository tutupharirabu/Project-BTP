<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\Gambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminStatusRuanganController extends Controller
{
    public function index()
    {
        $dataRuangan = Ruangan::with('gambar')->paginate(10);
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
            'status' => 'required',
            'url' => 'required|array',
            'url.*' => 'required|image'
        ]);

        $pilih = $request->input('status');

        if ($pilih == 'Available') {
            $ruangan = Ruangan::create([
                'nama_ruangan' => $request->nama_ruangan,
                'kapasitas_ruangan' => $request->kapasitas_ruangan,
                'lokasi' => $request->lokasi,
                'harga_ruangan' => $request->harga_ruangan,
                'tersedia' => '1',
                'status' => ''
            ]);
        } else if ($pilih == 'Booked') {
            $ruangan = Ruangan::create([
                'nama_ruangan' => $request->nama_ruangan,
                'kapasitas_ruangan' => $request->kapasitas_ruangan,
                'lokasi' => $request->lokasi,
                'harga_ruangan' => $request->harga_ruangan,
                'tersedia' => '0',
                'status' => '-',
            ]);
        }

        foreach($request->file('url') as $file){
            $path = $file->store('ruangan', 'assets');
            Gambar::create([
                'id_ruangan' => $ruangan->id_ruangan,
                'url' => $path
            ]);
        }

        return redirect('/statusRuanganAdmin')->with('success', 'Ruangan dan Gambar berhasil ditambahkan');
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
            // 'url' => 'required|array',
            // 'url.*' => 'required|image'
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
                Storage::delete('assets/' . $gambar->url);
                $gambar->delete();
            }

            // Tambahkan gambar baru
            foreach ($request->file('url') as $file) {
                $path = $file->store('ruangan', 'assets');
                Gambar::create([
                    'id_ruangan' => $dataRuangan->id_ruangan,
                    'url' => $path
                ]);
            }
        }
        return redirect('/statusRuanganAdmin')->with('success', 'Ruangan updated successfully~');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Ruangan::find($id);
        \DB::table('gambar')->where('id_ruangan', $data->id_ruangan)->delete();
        $data -> delete();
        return redirect()->route('admin.status');
    }
}
