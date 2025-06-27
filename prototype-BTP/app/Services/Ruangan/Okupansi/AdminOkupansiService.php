<?php

namespace App\Services\Ruangan\Okupansi;

use App\Enums\Database\RuanganDatabaseColumn;
use Carbon\Carbon;
use App\Interfaces\Repositories\Ruangan\BaseRuanganRepositoryInterface;
use App\Interfaces\Repositories\Ruangan\Okupansi\AdminOkupansiRepositoryInterface;

class AdminOkupansiService
{
  protected AdminOkupansiRepositoryInterface $adminOkupansiRepository;
  protected BaseRuanganRepositoryInterface $baseRuanganRepository;

  public function __construct(AdminOkupansiRepositoryInterface $adminOkupansiRepositoryInterface, BaseRuanganRepositoryInterface $baseRuanganRepositoryInterface)
  {
    $this->adminOkupansiRepository = $adminOkupansiRepositoryInterface;
    $this->baseRuanganRepository = $baseRuanganRepositoryInterface;
  }

  public function getOkupansiData(string $selectedMonth): array
  {
    $start = Carbon::parse($selectedMonth)->startOfMonth();
    $end = Carbon::parse($selectedMonth)->endOfMonth();

    $dataOkupansi = $this->adminOkupansiRepository->getPeminjamanByMonth($start, $end);
    $dataRuangan = $this->baseRuanganRepository->getAllRuangan();

    $dayOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    $dataByDayAndRoom = [];
    $totalByRoom = [];
    $totalByDay = [];

    foreach ($dayOrder as $day) {
      $dataByDayAndRoom[$day] = [];
    }

    foreach ($dataOkupansi as $peminjaman) {
      $startDate = Carbon::parse($peminjaman->tanggal_mulai);
      $endDate = Carbon::parse($peminjaman->tanggal_selesai);
      $room = $peminjaman->ruangan->nama_ruangan;
      $jumlahPeserta = $peminjaman->jumlah;

      for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
        $day = $date->translatedFormat('l');

        if (!isset($dataByDayAndRoom[$day][$room])) {
          $dataByDayAndRoom[$day][$room] = 0;
        }
        $dataByDayAndRoom[$day][$room] += $jumlahPeserta;

        if (!isset($totalByDay[$day])) {
          $totalByDay[$day] = 0;
        }
        $totalByDay[$day] += $jumlahPeserta;

        if (!isset($totalByRoom[$room])) {
          $totalByRoom[$room] = 0;
        }
        $totalByRoom[$room] += $jumlahPeserta;
      }
    }

    $totalOverall = array_sum($totalByDay);

    return compact('dataByDayAndRoom', 'dataRuangan', 'totalByDay', 'totalOverall', 'totalByRoom', 'dayOrder');
  }

  public function generateCsvData(array $okupansiData, string $selectedMonth): array
  {
    extract($okupansiData);

    $kapasitasMaksimalColumn = RuanganDatabaseColumn::KapasitasMaksimal->value;

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
    $csvData[] = array_merge(['Kapasitas penggunaan per ruangan (jumlah orang)'], array_column($dataRuangan->toArray(), $kapasitasMaksimalColumn));
    $csvData[] = array_merge(['1 Sesi 4 Jam, 1 hari 3 sesi'], array_map(fn($dr) => $dr[$kapasitasMaksimalColumn] * 3, $dataRuangan->toArray()));
    $csvData[] = array_merge(['Penggunaan kapasitas maksimum per ruangan dalam 1 bulan (31 hari)'], array_map(fn($dr) => $dr[$kapasitasMaksimalColumn] * 3 * 31, $dataRuangan->toArray()));
    $totalCapacityMonthly = array_reduce($dataRuangan->toArray(), function ($carry, $dr) use ($kapasitasMaksimalColumn) {
      return $carry + $dr[$kapasitasMaksimalColumn] * 3 * 31;
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

    return ['csvData' => $csvData, 'totalCapacityMonthly' => $totalCapacityMonthly];
  }
}