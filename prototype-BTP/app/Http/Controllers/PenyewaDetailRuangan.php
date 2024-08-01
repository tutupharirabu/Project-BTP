<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ruangan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyewaDetailRuangan extends Controller
{
    public function show($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $dataRuangan = Ruangan::all();

        $peminjamans = Peminjaman::with('ruangan')->where('id_ruangan', $id)->whereIn('status', ['Disetujui', 'Selesai'])->get();

        $events = array();
        foreach($peminjamans as $peminjaman){
            $events[] = [
                'title' => $peminjaman->nama_peminjam." - ".$peminjaman->ruangan->nama_ruangan,
                'peminjam' => $peminjaman->nama_peminjam,
                'ruangan' => $peminjaman->ruangan->nama_ruangan,
                'start' => $peminjaman->tanggal_mulai,
                'end' => $peminjaman->tanggal_selesai,
                'ruangan_id' => $peminjaman->id_ruangan, // Add the ruangan_id field
            ];
        }

        return view('penyewa.detailRuanganPenyewa', compact('ruangan', 'dataRuangan', 'events'));
    }

    public function getAvailableTimes(Request $request)
    {
        $tanggalMulai = Carbon::parse($request->input('tanggal_mulai'));
        $tanggalSelesai = Carbon::parse($request->input('tanggal_selesai', $tanggalMulai->copy()->addDays(6)->toDateString())); // Default to 6 days after start date
        $ruanganId = $request->input('ruangan_id');

        try {
            // Debugging log
            \Log::info("Tanggal Mulai: $tanggalMulai, Tanggal Selesai: $tanggalSelesai, Ruangan ID: $ruanganId");

            $usedTimes = DB::table('peminjaman')
                ->where('id_ruangan', $ruanganId)
                ->where(function($query) use ($tanggalMulai, $tanggalSelesai) {
                    $query->whereDate('tanggal_mulai', '<=', $tanggalSelesai)
                        ->whereDate('tanggal_selesai', '>=', $tanggalMulai);
                })
                ->whereIn('status', ['Disetujui', 'Selesai'])
                ->get();

            \Log::info("Used Times for Ruangan $ruanganId: ", $usedTimes->toArray());

            $usedTimeSlots = [];
            foreach ($usedTimes as $time) {
                $start = Carbon::parse($time->tanggal_mulai);
                $end = Carbon::parse($time->tanggal_selesai);
                while ($start <= $end) {
                    $usedTimeSlots[] = [
                        'date' => $start->format('Y-m-d'),
                        'time' => $start->format('H:i'),
                        'ruangan' => $ruanganId
                    ];
                    $start->addMinutes(30);
                }
            }

            return response()->json([
                'usedTimeSlots' => $usedTimeSlots
            ]);
        } catch (\Exception $e) {
            \Log::error("Error: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

}
