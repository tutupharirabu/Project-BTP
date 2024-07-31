<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Users;
use App\Models\Ruangan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'nama_peminjam' => 'required|string',
            'nomor_induk' => 'required',
            'nomor_telepon' => 'required',
            'id_ruangan' => 'required',
            'role' => 'required',
            'tanggal_mulai' => 'required|date',
            'jam_mulai' => 'required', // Pastikan 'jam_mulai' di-validasi
            'jumlah' => 'required|integer',
            // 'keterangan' => 'required|string',
        ]);

        $keterangan = $request->input('keterangan');
        if($keterangan == NULL){
            $keterangan = '~';
        }

        $status = $request->input('role');
        if ($status == 'Mahasiswa' || $status == 'Umum') {
            $request->validate([
                'durasi' => 'required',
            ]);
        } else {
            $request->validate([
                'tanggal_selesai' => 'required|date',
                'jam_selesai' => 'required', // Pastikan 'jam_selesai' di-validasi
            ]);
        }
        $tanggal_mulai = $request->input('tanggal_mulai') . ' ' . $request->input('jam_mulai');

        if ($status == 'Mahasiswa' || $status == 'Umum') {
            $durasi = $request->input('durasi');
            $tanggalMulai = $request->input('tanggal_mulai');
            $jamMulai = $request->input('jam_mulai');

            // Mengonversi durasi menjadi menit
            $durasiInMinutes = Carbon::parse($durasi)->diffInMinutes(Carbon::parse('00:00'));

            $startTime = Carbon::parse($jamMulai);
            $endTime = $startTime->addMinutes($durasiInMinutes);

            // Menggunakan waktu akhir yang dihitung tanpa tambahan satu jam ekstra
            $tanggal_selesai_plus_one_hour = Carbon::parse($tanggalMulai . ' ' . $endTime->format('H:i:s'));
        } else {
            $tanggal_selesai = $request->input('tanggal_selesai') . ' ' . $request->input('jam_selesai');
            $datetime = Carbon::createFromFormat('Y-m-d H:i', $tanggal_selesai);

            // Menambah satu jam ke tanggal selesai
            $datetime->addHour();
            $tanggal_selesai_plus_one_hour = $datetime->format('Y-m-d H:i:s');
        }

        $meminjamRuangan = new Peminjaman([
            'nama_peminjam' => $request->input('nama_peminjam'),
            'nomor_induk' => $request->input('nomor_induk'),
            'nomor_telepon' => $request->input('nomor_telepon'),
            'id_ruangan' => $request->input('id_ruangan'),
            'role' => $request->input('role'),
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai_plus_one_hour,
            'jumlah' => $request->input('jumlah'),
            'status' => 'Menunggu',
            'keterangan' => $keterangan,
        ]);

        $meminjamRuangan->save();

        return redirect('/dashboardPenyewa')->with('success', 'Daftar Meminjam Ruangan Berhasil');
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
