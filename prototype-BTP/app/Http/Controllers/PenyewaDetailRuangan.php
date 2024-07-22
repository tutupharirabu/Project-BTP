<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PenyewaDetailRuangan extends Controller
{
    public function show($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $dataRuangan = Ruangan::all();
        return view('penyewa.detailRuanganPenyewa', compact('ruangan', 'dataRuangan'));
    }

    public function getAvailableTimes(Request $request)
    {
        $tanggalMulai = Carbon::parse($request->input('tanggal_mulai'));
        $ruangan = $request->input('ruangan');
        $tanggalSelesai = Carbon::parse($request->input('tanggal_selesai', $tanggalMulai->copy()->addDays(6)->toDateString())); // Default to 6 days after start date

        try {
            // Debugging log
            \Log::info("Tanggal Mulai: $tanggalMulai, Tanggal Selesai: $tanggalSelesai, Ruangan: $ruangan");

            $usedTimes = DB::table('peminjaman')
                ->where('id_ruangan', $ruangan)
                ->where(function($query) use ($tanggalMulai, $tanggalSelesai) {
                    $query->whereDate('tanggal_mulai', '<=', $tanggalSelesai)
                          ->whereDate('tanggal_selesai', '>=', $tanggalMulai);
                })
                ->whereIn('status', ['Disetujui', 'Selesai'])
                ->get();

            \Log::info("Used Times: ", $usedTimes->toArray());

            $usedTimeSlots = [];
            foreach ($usedTimes as $time) {
                $start = Carbon::parse($time->tanggal_mulai);
                $end = Carbon::parse($time->tanggal_selesai);
                while ($start <= $end) {
                    $usedTimeSlots[] = [
                        'date' => $start->format('Y-m-d'),
                        'time' => $start->format('H:i')
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
