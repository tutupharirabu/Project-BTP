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
        return view('penyewa.detailRuanganPenyewa', compact('ruangan'));
    }

    public function getAvailableTimes(Request $request)
    {
        $tanggalMulai = Carbon::parse($request->input('tanggal_mulai'));

        // Query untuk mendapatkan waktu yang digunakan pada tanggal_mulai dengan status Disetujui
        $usedTimes = DB::table('peminjaman')
            ->where(function($query) use ($tanggalMulai) {
                $query->whereDate('tanggal_mulai', $tanggalMulai)
                        ->orWhereDate('tanggal_selesai', $tanggalMulai)
                        ->orWhereBetween('tanggal_mulai', [$tanggalMulai, $tanggalMulai->copy()->addDays(6)])
                        ->orWhereBetween('tanggal_selesai', [$tanggalMulai, $tanggalMulai->copy()->addDays(6)]);
            })
            ->where('status', 'Disetujui')
            ->get();

        // Convert usedTimes to an array of time slots
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
    }
}
