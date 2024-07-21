<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class OkupansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil peminjaman yang disetujui dan selesai
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

        return view('admin.okupansi', compact('dataByDayAndRoom', 'dataRuangan', 'totalByDay', 'totalOverall', 'totalByRoom'));
    }

    public function downloadOkupansi()
    {
        // Ambil peminjaman yang disetujui dan selesai
        $dataOkupansi = Peminjaman::with('ruangan')
            ->whereIn('status', ['Disetujui', 'Selesai'])
            ->get();

        $dataRuangan = Ruangan::all();
        $dataByDayAndRoom = [];
        $totalByRoom = [];
        $totalByDay = [];

        // Define the start and end of the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Generate a list of all dates in the month
        $datesInMonth = [];
        $currentDay = $startOfMonth->copy();
        while ($currentDay->lte($endOfMonth)) {
            $datesInMonth[] = $currentDay->format('d-m-Y'); // Store dates in YYYY-MM-DD format
            $currentDay->addDay();
        }

        // Initialize data structures
        foreach ($dataRuangan as $room) {
            $totalByRoom[$room->nama_ruangan] = 0;
            foreach ($datesInMonth as $date) {
                $dataByDayAndRoom[$date][$room->nama_ruangan] = 0;
            }
        }

        // Iterasi setiap peminjaman untuk menghitung jumlah peminjaman per ruangan per hari
        foreach ($dataOkupansi as $peminjaman) {
            $startDate = Carbon::parse($peminjaman->tanggal_mulai);
            $endDate = Carbon::parse($peminjaman->tanggal_selesai);
            $room = $peminjaman->ruangan->nama_ruangan;

            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $dateStr = $date->format('d-m-Y');

                if (isset($dataByDayAndRoom[$dateStr][$room])) {
                    $dataByDayAndRoom[$dateStr][$room]++;
                    $totalByRoom[$room]++;
                }

                // Hitung total peminjaman per hari
                if (!isset($totalByDay[$dateStr])) {
                    $totalByDay[$dateStr] = 0;
                }
                $totalByDay[$dateStr]++;
            }
        }

        // Total peminjaman untuk seluruh hari
        $totalOverall = array_sum($totalByDay);

        // Prepare data for CSV
        $csvData = [];
        $headers = ['Tanggal'];
        foreach ($dataRuangan as $dr) {
            $headers[] = $dr->nama_ruangan;
        }
        $csvData[] = $headers;

        // Fill in the CSV rows with booking data
        foreach ($datesInMonth as $date) {
            $row = [$date];
            foreach ($dataRuangan as $dr) {
                $row[] = $dataByDayAndRoom[$date][$dr->nama_ruangan] ?? 0;
            }
            $csvData[] = $row;
        }

        // Add totals
        $csvData[] = array_merge(['Jumlah'], array_values($totalByRoom));
        $csvData[] = ['Total', $totalOverall];
        $csvData[] = array_merge(['Kapasitas penggunaan per ruangan (jumlah orang)'], array_column($dataRuangan->toArray(), 'kapasitas_maksimal'));
        $csvData[] = array_merge(['1 Sesi 4 Jam, 1 hari 3 sesi'], array_map(fn($dr) => $dr['kapasitas_maksimal'] * 3, $dataRuangan->toArray()));
        $csvData[] = array_merge(['Penggunaan kapasitas maksimum per ruangan dalam 1 bulan (31 hari)'], array_map(fn($dr) => $dr['kapasitas_maksimal'] * 3 * 31, $dataRuangan->toArray()));
        $totalCapacityMonthly = array_reduce($dataRuangan->toArray(), function ($carry, $dr) {
            return $carry + $dr['kapasitas_maksimal'] * 3 * 31;
        }, 0);
        $csvData[] = array_merge(['Kapasitas maksimum semua ruangan'], [$totalCapacityMonthly]);

        // Occupancy percentages
        $occupancyData = ['Okupansi pemakaian per ruangan di BTP (dalam %)'];
        foreach ($dataRuangan as $dr) {
            $totalCapacity = $dr->kapasitas_maksimal * 3 * 31;
            $totalOccupancy = $totalByRoom[$dr->nama_ruangan] ?? 0;
            $occupancyPercentage = $totalCapacity > 0 ? ($totalOccupancy / $totalCapacity) * 100 : 0;
            $occupancyData[] = number_format($occupancyPercentage, 2) . '%';
        }
        $csvData[] = $occupancyData;
        $csvData[] = ['Okupansi pemakaian ruangan di BTP (dalam %)', number_format(($totalOverall / $totalCapacityMonthly) * 100, 2) . '%'];

        // Create a CSV file
        $fileName = 'Data Okupansi Peminjaman Ruangan BTP.csv';
        $file = fopen(storage_path('app/public/' . $fileName), 'w');
        foreach ($csvData as $line) {
            fputcsv($file, $line);
        }
        fclose($file);

        // Return the CSV file for download
        return Response::download(storage_path('app/public/' . $fileName));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
