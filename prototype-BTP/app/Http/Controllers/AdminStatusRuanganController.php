<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\Gambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use DB;

class AdminStatusRuanganController extends Controller
{
    public function index()
    {
        $dataRuangan = Ruangan::with(['gambar', 'users'])->orderBy('created_at', 'asc')->get();
        return view('admin.daftarRuanganAdmin',compact('dataRuangan'));
    }

    public function getEvents()
    {
        // $schedules = Schedule::all();
        // return response()->json($schedules);
    }

    public function checkRoomName(Request $request)
    {
        $namaRuangan = $request->input('nama_ruangan');
        $exists = Ruangan::where('nama_ruangan', $namaRuangan)->exists();

        return response()->json(['exists' => $exists]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.crud.tambahRuanganAdmin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|unique:ruangan,nama_ruangan',
            'ukuran' => 'required',
            'kapasitas_minimal' => 'required',
            'kapasitas_maksimal' => 'required',
            'lokasi' => 'required',
            'satuan' => 'required',
            // 'keterangan' => 'required',
            'harga_ruangan' => 'required',
            // 'status' => 'required',
            'url' => 'required|array',
            'url.*' => 'required|mimes:jpeg,png,jpg'
        ]);

        $pilih = $request->input('status');

        $keterangan = $request->input('keterangan');
        if($keterangan == NULL){
            $keterangan = '~';
        }

        $idUs = Auth::id();

        $ruangan = Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan,
            'ukuran' => $request->ukuran,
            'kapasitas_minimal' => $request->kapasitas_minimal,
            'kapasitas_maksimal' => $request->kapasitas_maksimal,
            'lokasi' => $request->lokasi,
            'satuan' => $request->satuan,
            'harga_ruangan' => $request->harga_ruangan,
            'tersedia' => '1',
            'status' => 'Tersedia',
            'keterangan' => $keterangan,
            'id_users' => $idUs,
        ]);

        foreach($request->file('url') as $file){
            $path = $file->store('ruangan', 'assets');
            Gambar::create([
                'id_ruangan' => $ruangan->id_ruangan,
                'url' => $path
            ]);
        }

        return redirect('/statusRuanganAdmin')->with('success', 'Ruangan dan Gambar berhasil ditambahkan');
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
        return view('admin.crud.editRuanganAdmin', ['dataRuangan' => $dataRuangan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataRuangan = Ruangan::find($id);

        // Validasi input
        $request->validate([
            'nama_ruangan' => 'required|string',
            'ukuran' => 'required',
            'kapasitas_minimal' => 'required',
            'kapasitas_maksimal' => 'required',
            'lokasi' => 'required',
            'satuan' => 'required',
            'harga_ruangan' => 'required',
            'tersedia' => 'required',
            'status' => 'required',
            'url.*' => 'image|mimes:jpeg,png,jpg'
        ]);

        // Update data ruangan
        $this->updateRuangan($dataRuangan, $request);

        // Upload gambar jika ada
        if ($request->hasFile('url')) {
            $this->uploadGambar($dataRuangan, $request);
        }

        return redirect('/statusRuanganAdmin')->with('success', 'Ruangan updated successfully~');
    }

    protected function updateRuangan($dataRuangan, $request)
    {
        $idUs = Auth::id();

        $dataRuangan->nama_ruangan = $request->input('nama_ruangan');
        $dataRuangan->ukuran = $request->input('ukuran');
        $dataRuangan->kapasitas_minimal = $request->input('kapasitas_minimal');
        $dataRuangan->kapasitas_maksimal = $request->input('kapasitas_maksimal');
        $dataRuangan->satuan = $request->input('satuan');
        $dataRuangan->lokasi = $request->input('lokasi');
        $dataRuangan->harga_ruangan = $request->input('harga_ruangan');
        $dataRuangan->tersedia = $request->input('tersedia');
        $dataRuangan->status = $request->input('status');
        $dataRuangan->keterangan = $request->input('keterangan');
        $dataRuangan->id_users = $idUs;

        $dataRuangan->save();
    }

    protected function uploadGambar($dataRuangan, $request)
    {
        // Hapus gambar lama dari penyimpanan
        foreach ($dataRuangan->gambar as $gambar) {
            Storage::delete('assets/' . $gambar->url);
        }

        // Perbarui gambar dengan yang baru
        $files = $request->file('url');
        foreach ($dataRuangan->gambar as $index => $gambar) {
            if (isset($files[$index])) {
                $file = $files[$index];
                $path = $file->store('ruangan', 'assets');
                $gambar->url = $path;
                $gambar->save();
            }
        }

        // Tambahkan gambar baru jika ada lebih banyak file daripada gambar yang ada
        for ($i = count($dataRuangan->gambar); $i < count($files); $i++) {
            $file = $files[$i];
            $path = $file->store('ruangan', 'assets');
            Gambar::create([
                'id_ruangan' => $dataRuangan->id_ruangan,
                'url' => $path
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Ruangan::find($id);
        DB::table('gambar')->where('id_ruangan', $data->id_ruangan)->delete();
        $data -> delete();
        return redirect()->route('admin.status');
    }
}
