<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\Ruangan;
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

        // Calculate occupancy percentage
        $dataRuangan = Ruangan::all();
        $totalOverall = 0;
        $totalCapacityMonthly = 0;

        foreach ($dataRuangan as $dr) {
            $totalCapacity = $dr->kapasitas_maksimal * 3 * 31; // 3 sessions per day, 31 days
            $totalCapacityMonthly += $totalCapacity;

            $totalOccupancy = Peminjaman::where('id_ruangan', $dr->id)
                ->whereIn('status', ['Disetujui', 'Selesai'])
                ->count();

            $totalOverall += $totalOccupancy;
        }

        $occupancyOverallPercentage = $totalCapacityMonthly > 0 
            ? number_format(($totalOverall / $totalCapacityMonthly) * 100, 2) 
            : 0;

        return view('admin/adminDashboard', compact('peminjamans', 'events', 'peminjamanPerBulan', 'occupancyOverallPercentage'));
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

