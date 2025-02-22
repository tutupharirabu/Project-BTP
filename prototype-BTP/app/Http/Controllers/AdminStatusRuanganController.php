<?php

namespace App\Http\Controllers;

// Mengubah batas waktu eksekusi menjadi 300 detik (5 menit)
ini_set('max_execution_time', 300);

use DB;
use App\Models\Gambar;
use App\Models\Ruangan;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminStatusRuanganController extends Controller
{
    public function index()
    {
        $dataRuangan = Ruangan::with(['gambar', 'users'])->orderBy('created_at', 'desc')->get();
        return view('admin.daftarRuanganAdmin', compact('dataRuangan'));
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
        // Tambahkan ini sebelum validasi
        if (!$request->hasFile('url')) {
            // Log atau tampilkan pesan bahwa 'url' tidak ada
            \Log::info('URL tidak ada dalam request');

            // Opsional: dump seluruh request untuk melihat apa yang dikirim
            \Log::info('Request data: ' . json_encode($request->all()));
        }

        try {
            $validated = $request->validate([
                'nama_ruangan' => 'required|string|unique:ruangan,nama_ruangan',
                'ukuran' => 'required',
                'kapasitas_minimal' => 'required',
                'kapasitas_maksimal' => 'required',
                'lokasi' => 'required',
                'satuan' => 'required',
                'harga_ruangan' => 'required',
                'url' => 'required|array',
                'url.*' => 'image|mimes:jpeg,png,jpg|max:2048' // Hanya validasi gambar utama
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ' . json_encode($e->errors()));
            throw $e;
        }

        $keterangan = $request->input('keterangan');
        if ($keterangan == NULL) {
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

        // Upload gambar ke Cloudinary
        if ($request->hasFile('url')) {
            foreach ($request->file('url') as $index => $file) {
                // Skip bila tidak ada file (untuk gambar opsional)
                if (!$file) {
                    continue;
                }

                // Hanya proses file yang valid
                if ($file->isValid()) {
                    try {
                        $cloudinary = new Cloudinary();

                        $uploadResult = $cloudinary->uploadApi()->upload(
                            $file->getRealPath(),
                            [
                                'folder' => 'spacerent-btp/ruangan-btp',
                                'public_id' => $ruangan->id_ruangan . '_' . 'image_' . $index + 1
                            ]
                        );

                        // Simpan URL Cloudinary ke database
                        Gambar::create([
                            'id_ruangan' => $ruangan->id_ruangan,
                            'url' => $uploadResult['secure_url']
                        ]);

                    } catch (\Exception $e) {
                        // Log error jika upload gagal
                        \Log::error('Error uploading to Cloudinary:', [
                            'message' => $e->getMessage(),
                            'file_index' => $index
                        ]);
                        // Lanjutkan ke file berikutnya
                        continue;
                    }
                }
            }
        }

        return redirect('/daftarRuanganAdmin')->with('success', 'Ruangan dan Gambar berhasil ditambahkan');
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
        try {
            $validated = $request->validate([
                'nama_ruangan' => 'required|string',
                'ukuran' => 'required',
                'kapasitas_minimal' => 'required',
                'kapasitas_maksimal' => 'required',
                'lokasi' => 'required',
                'satuan' => 'required',
                'harga_ruangan' => 'required',
                'tersedia' => 'required',
                'status' => 'required',
                'url.*' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ' . json_encode($e->errors()));
            throw $e;
        }

        // Update data ruangan
        $this->updateRuangan($dataRuangan, $request);

        // Upload gambar jika ada
        if ($request->hasFile('url')) {
            $this->uploadGambarToCloudinary($dataRuangan, $request);
        }

        return redirect('/daftarRuanganAdmin')->with('success', 'Ruangan updated successfully~');
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
        $dataRuangan->keterangan = $request->input('keterangan') ?? '~';
        $dataRuangan->id_users = $idUs;

        $dataRuangan->save();
    }

    protected function uploadGambarToCloudinary($dataRuangan, $request)
    {
        // Urutkan gambar yang sudah ada berdasarkan indeks dalam public_id
        $existingGambar = $dataRuangan->gambar
            ->sortBy(function ($gambar) {
                preg_match('/_image_(\d+)/', $gambar->url, $matches);
                return isset($matches[1]) ? (int) $matches[1] : 999;
            })
            ->values()
            ->toArray();
        $totalExisting = count($existingGambar);

        // Dapatkan file yang diupload
        $files = $request->file('url');

        // Loop melalui semua file yang diupload
        foreach ($files as $index => $file) {
            // Skip bila tidak ada file
            if (!$file || !$file->isValid()) {
                continue;
            }

            try {
                $cloudinary = new Cloudinary();

                // Tentukan public_id
                $public_id = $dataRuangan->id_ruangan . '_' . 'image_' . ($index+1);

                // Upload dengan fitur overwrite = true (mengganti gambar lama)
                $uploadResult = $cloudinary->uploadApi()->upload(
                    $file->getRealPath(),
                    [
                        'folder' => 'spacerent-btp/ruangan-btp',
                        'public_id' => $public_id,
                        'overwrite' => true
                    ]
                );

                // Jika index masih dalam jangkauan gambar yang sudah ada, update gambar yang ada
                if ($index < $totalExisting) {
                    $gambar = Gambar::find($existingGambar[$index]['id_gambar']);
                    if ($gambar) {
                        // Update URL gambar di database - tidak perlu menghapus gambar lama
                        $gambar->url = $uploadResult['secure_url'];
                        $gambar->save();
                    }
                } else {
                    // Jika diluar jangkauan, buat gambar baru
                    Gambar::create([
                        'id_ruangan' => $dataRuangan->id_ruangan,
                        'url' => $uploadResult['secure_url']
                    ]);
                }

            } catch (\Exception $e) {
                // Log error jika upload gagal
                \Log::error('Error uploading to Cloudinary:', [
                    'message' => $e->getMessage(),
                    'file_index' => $index,
                    'ruangan_id' => $dataRuangan->id_ruangan
                ]);
                // Lanjutkan ke file berikutnya
                continue;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Ruangan::find($id);
        DB::table('gambar')->where('id_ruangan', $data->id_ruangan)->delete();
        $data->delete();
        return redirect()->route('admin.status');
    }
}
