<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use Carbon\Carbon;
use DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Fetch approved or completed bookings
        $peminjamans = Peminjaman::with('ruangan')->whereIn('status', ['Disetujui', 'Selesai'])->get();

        // Prepare calendar events
        $events = array();
        foreach ($peminjamans as $peminjaman) {
            $events[] = [
                'title' => $peminjaman->nama_peminjam . ' ' . $peminjaman->ruangan->nama_ruangan,
                'nama' => $peminjaman->nama_peminjam,
                'ruangan' => $peminjaman->ruangan->nama_ruangan,
                'start' => $peminjaman->tanggal_mulai,
                'end' => $peminjaman->tanggal_selesai,
            ];
        }

        // Calculate occupancy percentage per month
        $occupancyPerMonth = [];
        $dataRuangan = Ruangan::all();

        // Initialize with zeros for all months
        for ($i = 1; $i <= 12; $i++) {
            $occupancyPerMonth[$i] = 0;
        }

        // Calculate the total capacity for each room
        $totalCapacityPerRoom = $dataRuangan->reduce(function ($carry, $room) {
            return $carry + ($room->kapasitas_maksimal * 3 * 31); // 3 sessions per day, 31 days
        }, 0);

        // Calculate the total usage per month
        foreach ($peminjamans as $peminjaman) {
            $startDate = Carbon::parse($peminjaman->tanggal_mulai);
            $endDate = Carbon::parse($peminjaman->tanggal_selesai);
            $daysUsed = $startDate->diffInDays($endDate) + 1; // Including the start and end date

            // Calculate the occupancy for each month within the booking period
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $month = $date->month;
                $occupancyPerMonth[$month] += $peminjaman->jumlah; // Assuming jumlah_peserta is the occupancy count
            }
        }

        // Convert occupancy counts to percentages
        foreach ($occupancyPerMonth as $month => $count) {
            $occupancyPerMonth[$month] = $totalCapacityPerRoom > 0
                ? number_format(($count / $totalCapacityPerRoom) * 100, 2)
                : 0;
        }

        return view('admin/adminDashboard', compact('peminjamans', 'events', 'occupancyPerMonth', 'totalCapacityPerRoom'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

