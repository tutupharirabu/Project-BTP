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
        $peminjamans = Peminjaman::with('ruangan')->whereIn('status', ['Disetujui', 'Selesai'])->get();

        $events = array();
        foreach ($peminjamans as $peminjaman) {
            $events[] = [
                'title' => $peminjaman->nama_peminjam . ' ' . $peminjaman->ruangan->nama_ruangan,
                'ruangan' => $peminjaman->ruangan->nama_ruangan,
                'start' => $peminjaman->tanggal_mulai,
                'end' => $peminjaman->tanggal_selesai,
            ];
        }

        $peminjamanPerBulan = Peminjaman::select(
            DB::raw('MONTH(tanggal_mulai) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->where('status', 'Selesai')
            ->groupBy('bulan')
            ->get();

        $defaultMonths = [
            1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0,
            7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0
        ];

        foreach ($peminjamanPerBulan as $peminjaman) {
            $defaultMonths[$peminjaman->bulan] = $peminjaman->total;
        }

        $peminjamanPerBulan = collect($defaultMonths)->map(function ($total, $bulan) {
            return (object) ['bulan' => $bulan, 'total' => $total];
        })->values();

        // Okupansi
        $dataOkupansi = Peminjaman::with('ruangan')
            ->whereIn('status', ['Disetujui', 'Selesai'])
            ->get();

        $dataRuangan = Ruangan::all();
        $dataByDayAndRoom = [];
        $totalByRoom = [];
        $totalByDay = [];

        // Iterasi setiap peminjaman untuk menghitung jumlah peminjaman per ruangan per hari
        foreach ($dataOkupansi as $peminjaman) {
            $startDate = Carbon::parse($peminjaman->tanggal_mulai);
            $endDate = Carbon::parse($peminjaman->tanggal_selesai);
            $room = $peminjaman->ruangan->nama_ruangan;

            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $day = $date->translatedFormat('l');

                if (!isset($dataByDayAndRoom[$day])) {
                    $dataByDayAndRoom[$day] = [];
                }

                if (!isset($dataByDayAndRoom[$day][$room])) {
                    $dataByDayAndRoom[$day][$room] = 0;
                }

                $dataByDayAndRoom[$day][$room]++;

                // Hitung total peminjaman per hari
                if (!isset($totalByDay[$day])) {
                    $totalByDay[$day] = 0;
                }

                $totalByDay[$day]++;

                // Hitung total peminjaman per ruangan
                if (!isset($totalByRoom[$room])) {
                    $totalByRoom[$room] = 0;
                }
                $totalByRoom[$room]++;
            }
        }

        // Total peminjaman untuk seluruh hari
        $totalOverall = array_sum($totalByDay);

        // Calculate occupancy percentage
        $totalCapacityMonthly = 0;

        foreach ($dataRuangan as $dr) {
            $totalCapacity = $dr->kapasitas_maksimal * 3 * 31; // 3 sessions per day, 31 days
            $totalCapacityMonthly = $dataRuangan->reduce(function ($carry, $dr) {
                return $carry + $dr->kapasitas_maksimal * 3 * 31;
            }, 0);
        }
        
        $occupancyOverallPercentage = $totalCapacityMonthly > 0
            ? number_format(($totalOverall / $totalCapacityMonthly) * 100, 2)
            : 0;

        return view('admin/adminDashboard', compact('peminjamans', 'events', 'peminjamanPerBulan', 'occupancyOverallPercentage','totalOverall','totalCapacityMonthly'));
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

