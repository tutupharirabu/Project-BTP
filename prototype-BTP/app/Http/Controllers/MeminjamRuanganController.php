<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\Peminjaman;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            'btnradio' => 'required',
            'nama_peminjam' => 'required|string',
            'role' => 'required',
            'id_ruangan' => 'required',
            'tanggal_mulai' => 'required|date',
            'jam_mulai' => 'required', // Pastikan 'jam_mulai' di-validasi
            'jumlah' => 'required|integer',
            'keterangan' => 'required|string',
        ]);

        $mode_peminjaman = $request->input('btnradio') == 'per_jam' ? 'per_jam' : 'per_hari';

        if ($mode_peminjaman == 'per_jam') {
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

        if($mode_peminjaman == 'per_jam') {
            $durasi = $request->input('durasi');
            $tanggalMulai = $request->input('tanggal_mulai');
            $jamMulai = $request->input('jam_mulai');

            $durasiInMinutes = Carbon::parse($durasi)->diffInMinutes(Carbon::today());

            $startTime = Carbon::parse($jamMulai);

            $endTime = $startTime->addMinutes($durasiInMinutes);
            $endTime->addHour();

            $tanggal_selesai_plus_one_hour = Carbon::parse($tanggalMulai . ' ' . $endTime->format('H:i:s'));
        } else {
            $tanggal_selesai = $request->input('tanggal_selesai').' '.$request->input('jam_selesai');

            // Membuat objek Carbon dari tanggal dan jam selesai
            $datetime = Carbon::createFromFormat('Y-m-d H:i', $tanggal_selesai);

            // Menambah 1 jam
            $datetime->addHour();

            // Mengubah kembali ke format string
            $tanggal_selesai_plus_one_hour = $datetime->format('Y-m-d H:i:s');
        }

        $meminjamRuangan = new Peminjaman([
            'nama_peminjam' => $request->input('nama_peminjam'),
            'role' => $request->input('role'),
            'id_ruangan' => $request->input('id_ruangan'),
            'id_barang' => null,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai_plus_one_hour,
            'jumlah' => $request->input('jumlah'),
            'status' => 'Menunggu',
            'keterangan' => $request->input('keterangan'),
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
