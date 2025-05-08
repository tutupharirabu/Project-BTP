<?php

namespace App\Http\Controllers;

use Cloudinary\Cloudinary;
use Carbon\Carbon;
use App\Models\Ruangan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        $origin = 'dashboard'; // Asumsi default asal dari dashboard

        return view('penyewa.meminjamRuangan', compact('dataPeminjaman', 'dataRuangan', 'origin'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'nama_peminjam' => 'required|string',
            'nomor_induk' => 'required',
            'nomor_telepon' => 'required',
            'id_ruangan' => 'required',
            'role' => 'required',
            'tanggal_mulai' => 'required|date',
            'jam_mulai' => 'required', // Make sure 'jam_mulai' is validated
            'jumlah' => 'required|integer',
            // 'keterangan' => 'required|string',
        ]);

        $keterangan = $request->input('keterangan');
        if ($keterangan == NULL) {
            $keterangan = '~';
        }

        $uploadedFileUrl = null;

        // Handle file upload for 'ktp_url'
        $status = $request->input('role');
        if ($status == 'Pegawai') {
            $request->validate([
                'tanggal_selesai' => 'required|date',
                'jam_selesai' => 'required',
            ]);
        }

        $tanggal_mulai = $request->input('tanggal_mulai') . ' ' . $request->input('jam_mulai');

        if ($status == 'Mahasiswa' || $status == 'Umum') {
            $request->validate([
                'ktp_url' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            try {
                $cloudinary = new Cloudinary();
                $uploadedFileUrl = $cloudinary->uploadApi()->upload($request->file('ktp_url')->getRealPath(), [
                    'folder' => 'spacerent-btp/ktp-btp',
                    'transformation' => [
                        [
                            'overlay' => 'text:Arial_20:Confidential-Bandung Techno Park',
                            'color' => '#FF0000',
                            'opacity' => 50,
                            'gravity' => 'south_east',
                            'x' => 10,
                            'y' => 10,
                        ],
                    ],
                ])['secure_url'];
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['ktp_url' => 'Failed to upload KTP image.']);
            }

            // Continue handling for 'Mahasiswa' and 'Umum'
            $durasi = '04:00';
            $tanggalMulai = $request->input('tanggal_mulai');
            $jamMulai = $request->input('jam_mulai');

            // Convert duration into minutes
            $durasiInMinutes = Carbon::parse($durasi)->diffInMinutes(Carbon::parse('00:00'));

            $startTime = Carbon::parse($jamMulai);
            $endTime = $startTime->addMinutes($durasiInMinutes);

            // Using the calculated end time without adding an extra hour
            $tanggal_selesai_plus_one_hour = Carbon::parse($tanggalMulai . ' ' . $endTime->format('H:i:s'));
        } else {
            $tanggal_selesai = $request->input('tanggal_selesai') . ' ' . $request->input('jam_selesai');
            $datetime = Carbon::createFromFormat('Y-m-d H:i', $tanggal_selesai);

            // Adding one hour to the end date
            $datetime->addHour();
            $tanggal_selesai_plus_one_hour = $datetime->format('Y-m-d H:i:s');
        }

        // sql injection check
        $fieldsToCheck = [
            'nama_peminjam' => $validated['nama_peminjam'],
            'nomor_induk' => $validated['nomor_induk'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'keterangan' => $request->input('keterangan', '~'), 
        ];


        $response = $this->detectSQLInjection($fieldsToCheck);  
        // Log::info('SQL Injection Response: ', $response);
        // if (isset($response['is_sqli']) && $response['is_sqli'] && isset($response['probability'])) {
        //     return back()->withErrors([
        //         'sql_injection' => 'Input detected contains SQL Injection! Confidence: ' 
        //             . ($response['probability'] * 100) . '%'
        //     ])->withInput();
        // }

        // if (isset($response['is_sqli']) && $response['is_sqli'] && isset($response['probability'])) {
        //     return back()->withErrors([
        //         'sql_injection' => 'Input detected contains SQL Injection! Confidence: ' . ($response['probability'] * 100) . '%'
        //     ])->withInput();
        // }

        if (isset($response['is_sqli']) && $response['is_sqli'] && isset($response['probability'])) {
            return response()->json([
                'is_sqli' => true,
                'probability' => $response['probability']
            ], 400);  // Send a 400 status for SQLi error
        }
        

        // Create the new "Peminjaman" (Room Reservation)
        $meminjamRuangan = new Peminjaman([
            'nama_peminjam' => $request->input('nama_peminjam'),
            'nomor_induk' => $request->input('nomor_induk'),
            'nomor_telepon' => $request->input('nomor_telepon'),
            'id_ruangan' => $request->input('id_ruangan'),
            'ktp_url' => $uploadedFileUrl,
            'role' => $request->input('role'),
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai_plus_one_hour,
            'jumlah' => $request->input('jumlah'),
            'total_harga' => $request->input('total_harga'),
            'status' => 'Menunggu',
            'keterangan' => $keterangan,
        ]);

        $meminjamRuangan->save();

        return redirect('/dashboardPenyewa')->with('success', 'Daftar Meminjam Ruangan Berhasil');
    }


    private function detectSQLInjection(array $data)
    {
        try {
            $textToCheck = implode(' ', array_values($data));
            
            $response = Http::post('http://localhost:5000/detect_sqli', [
                'query' => $textToCheck
            ]);

            return $response->json();
        } catch (\Exception $e) {
            \Log::error('SQL Injection detection API error: ' . $e->getMessage());
            return ['is_sqli' => false, 'probability' => 0];
        }
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
    public function showPinjamRuangan($id)
    {
        $dataRuangan = Ruangan::all();
        $ruangan = Ruangan::find($id);
        if (!$ruangan) {
            return redirect()->route('daftarRuanganPenyewa')->with('error', 'Ruangan tidak ditemukan.');
        }
        $origin = 'detailRuangan'; // Asumsi asal dari detail ruangan

        return view('penyewa.meminjamRuangan', compact('ruangan', 'dataRuangan', 'origin'));
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
