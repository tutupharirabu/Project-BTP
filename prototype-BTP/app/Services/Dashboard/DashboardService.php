<?php

namespace App\Services\Dashboard;

use Carbon\Carbon;
use App\Enums\Relation\PeminjamanRelasi;
use App\Interfaces\Repositories\Dashboard\DashboardRepositoryInterface;
use App\Interfaces\Repositories\Ruangan\BaseRuanganRepositoryInterface;

class DashboardService
{
  protected DashboardRepositoryInterface $dashboardRepository;
  protected BaseRuanganRepositoryInterface $ruanganRepository;

  public function __construct(DashboardRepositoryInterface $dashboardRepositoryInterface, BaseRuanganRepositoryInterface $baseRuanganRepositoryInterface)
  {
    $this->dashboardRepository = $dashboardRepositoryInterface;
    $this->ruanganRepository = $baseRuanganRepositoryInterface;
  }

  public function getDashboardData(bool $forAdmin = false): array
  {
    $peminjamans = $this->dashboardRepository->getDisetujuiOrSelesaiWithRuangan();
    $ruangDashboard = $this->ruanganRepository->getAllRuangan();

    $events = [];
    foreach ($peminjamans as $peminjaman) {
      $sessions = $peminjaman->relationLoaded(PeminjamanRelasi::Sessions->value)
        ? $peminjaman->sessions
        : $peminjaman->sessions()->get();

      if ($sessions->isEmpty()) {
        $events[] = [
          'title' => $peminjaman->nama_peminjam . ' - ' . $peminjaman->ruangan->nama_ruangan,
          'peminjam' => $peminjaman->nama_peminjam,
          'ruangan' => $peminjaman->ruangan->nama_ruangan,
          'start' => Carbon::parse($peminjaman->tanggal_mulai)->timezone(config('app.timezone'))->format('Y-m-d H:i:s'),
          'end' => Carbon::parse($peminjaman->tanggal_selesai)->timezone(config('app.timezone'))->format('Y-m-d H:i:s'),
        ];
        continue;
      }

      foreach ($sessions as $session) {
        $events[] = [
          'title' => $peminjaman->nama_peminjam . ' - ' . $peminjaman->ruangan->nama_ruangan,
          'peminjam' => $peminjaman->nama_peminjam,
          'ruangan' => $peminjaman->ruangan->nama_ruangan,
          'start' => Carbon::parse($session->tanggal_mulai)->timezone(config('app.timezone'))->format('Y-m-d H:i:s'),
          'end' => Carbon::parse($session->tanggal_selesai)->timezone(config('app.timezone'))->format('Y-m-d H:i:s'),
        ];
      }
    }

    // Data khusus admin (misal occupancy)
    $occupancyPerMonth = [];
    $totalCapacityPerRoom = 0;
    if ($forAdmin) {
      for ($i = 1; $i <= 12; $i++) {
        $occupancyPerMonth[$i] = 0;
      }
      $totalCapacityPerRoom = $ruangDashboard->reduce(function ($carry, $room) {
        return $carry + ($room->kapasitas_maksimal * 3 * 31);
      }, 0);

      foreach ($peminjamans as $peminjaman) {
        $startDate = Carbon::parse($peminjaman->tanggal_mulai);
        $endDate = Carbon::parse($peminjaman->tanggal_selesai);
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
          $month = $date->month;
          $occupancyPerMonth[$month] += $peminjaman->jumlah;
        }
      }
      foreach ($occupancyPerMonth as $month => $count) {
        $occupancyPerMonth[$month] = $totalCapacityPerRoom > 0
          ? number_format(($count / $totalCapacityPerRoom) * 100, 2)
          : 0;
      }
    }

    return [
      'peminjamans' => $peminjamans,
      'events' => $events,
      'RuangDashboard' => $ruangDashboard,

      // Untuk admin, property tambahan
      'occupancyPerMonth' => $forAdmin ? $occupancyPerMonth : null,
      'totalCapacityPerRoom' => $forAdmin ? $totalCapacityPerRoom : null,
    ];
  }
}
