<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Response;

class OkupansiController extends Controller
{
    public function index(Request $request)
    {
        // Get the current month or the month from the request
        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));

        // Parse the start and end dates of the selected month
        $startOfMonth = Carbon::parse($selectedMonth)->startOfMonth();
        $endOfMonth = Carbon::parse($selectedMonth)->endOfMonth();

        // Fetch approved or completed bookings within the selected month
        $dataOkupansi = Peminjaman::with('ruangan')
            ->whereIn('status', ['Disetujui', 'Selesai'])
            ->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
            ->get();

        $dataRuangan = Ruangan::all();
        $dataByDayAndRoom = [];
        $totalByRoom = [];
        $totalByDay = [];

        // Iterate through each booking to count the bookings per room per day
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

                if (!isset($totalByDay[$day])) {
                    $totalByDay[$day] = 0;
                }
                $totalByDay[$day]++;

                if (!isset($totalByRoom[$room])) {
                    $totalByRoom[$room] = 0;
                }
                $totalByRoom[$room]++;
            }
        }

        $totalOverall = array_sum($totalByDay);

        return view('admin.okupansi', compact('dataByDayAndRoom', 'dataRuangan', 'totalByDay', 'totalOverall', 'totalByRoom', 'selectedMonth'));
    }

    public function downloadOkupansi(Request $request)
    {
        // Similar logic as the index method, adjusted for CSV generation
        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));
        $startOfMonth = Carbon::parse($selectedMonth)->startOfMonth();
        $endOfMonth = Carbon::parse($selectedMonth)->endOfMonth();

        // Fetch approved or completed bookings within the selected month
        $dataOkupansi = Peminjaman::with('ruangan')
            ->whereIn('status', ['Disetujui', 'Selesai'])
            ->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
            ->get();

        $dataRuangan = Ruangan::all();
        $dataByDayAndRoom = [];
        $totalByRoom = [];
        $totalByDay = [];

        // Similar iteration logic to the index method, adjusted for CSV generation
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

                if (!isset($totalByDay[$day])) {
                    $totalByDay[$day] = 0;
                }
                $totalByDay[$day]++;

                if (!isset($totalByRoom[$room])) {
                    $totalByRoom[$room] = 0;
                }
                $totalByRoom[$room]++;
            }
        }

        $totalOverall = array_sum($totalByDay);

        // CSV generation logic, similar to the original method but adjusted for the selected month
        $csvData = [];
        $headers = ['Tanggal'];
        foreach ($dataRuangan as $dr) {
            $headers[] = $dr->nama_ruangan;
        }
        $csvData[] = $headers;

        foreach ($dataByDayAndRoom as $date => $rooms) {
            $row = [$date];
            foreach ($dataRuangan as $dr) {
                $row[] = $rooms[$dr->nama_ruangan] ?? 0;
            }
            $csvData[] = $row;
        }

        $csvData[] = array_merge(['Jumlah'], array_values($totalByRoom));
        $csvData[] = ['Total', $totalOverall];
        $csvData[] = array_merge(['Kapasitas penggunaan per ruangan (jumlah orang)'], array_column($dataRuangan->toArray(), 'kapasitas_maksimal'));
        $csvData[] = array_merge(['1 Sesi 4 Jam, 1 hari 3 sesi'], array_map(fn($dr) => $dr['kapasitas_maksimal'] * 3, $dataRuangan->toArray()));
        $csvData[] = array_merge(['Penggunaan kapasitas maksimum per ruangan dalam 1 bulan (31 hari)'], array_map(fn($dr) => $dr['kapasitas_maksimal'] * 3 * 31, $dataRuangan->toArray()));
        $totalCapacityMonthly = array_reduce($dataRuangan->toArray(), function ($carry, $dr) {
            return $carry + $dr['kapasitas_maksimal'] * 3 * 31;
        }, 0);
        $csvData[] = array_merge(['Kapasitas maksimum semua ruangan'], [$totalCapacityMonthly]);

        $occupancyData = ['Okupansi pemakaian per ruangan di BTP (dalam %)'];
        foreach ($dataRuangan as $dr) {
            $totalCapacity = $dr->kapasitas_maksimal * 3 * 31;
            $totalOccupancy = $totalByRoom[$dr->nama_ruangan] ?? 0;
            $occupancyPercentage = $totalCapacity > 0 ? ($totalOccupancy / $totalCapacity) * 100 : 0;
            $occupancyData[] = number_format($occupancyPercentage, 2) . '%';
        }
        $csvData[] = $occupancyData;
        $csvData[] = ['Okupansi pemakaian ruangan di BTP (dalam %)', number_format(($totalOverall / $totalCapacityMonthly) * 100, 2) . '%'];

        $fileName = 'Data Okupansi Peminjaman Ruangan BTP.csv';
        $file = fopen(storage_path('app/public/' . $fileName), 'w');
        foreach ($csvData as $line) {
            fputcsv($file, $line);
        }
        fclose($file);

        return Response::download(storage_path('app/public/' . $fileName));
    }
}
