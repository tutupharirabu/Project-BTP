<?php

namespace App\Services\Ruangan;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Interfaces\Repositories\Ruangan\PenyewaRuanganRepositoryInterface;

class PenyewaRuanganService
{
  protected PenyewaRuanganRepositoryInterface $penyewaRuanganRepository;

  public function __construct(PenyewaRuanganRepositoryInterface $penyewaRuanganRepositoryInterface)
  {
    $this->penyewaRuanganRepository = $penyewaRuanganRepositoryInterface;
  }

  public function getRuanganDetailWithEvents(string $id): array
  {
    $ruangan = $this->penyewaRuanganRepository->getRuanganById($id);
    if (!$ruangan) {
      throw new \Exception('Ruangan tidak ditemukan');
    }

    $dataRuangan = $this->penyewaRuanganRepository->getAllRuangan();
    $peminjamans = $this->penyewaRuanganRepository->getApprovedPeminjamanRuangan($id);

    $events = [];
    foreach ($peminjamans as $peminjaman) {
      $events[] = [
        'title' => $peminjaman->nama_peminjam . " - " . $peminjaman->ruangan->nama_ruangan,
        'peminjam' => $peminjaman->nama_peminjam,
        'ruangan' => $peminjaman->ruangan->nama_ruangan,
        'start' => $peminjaman->tanggal_mulai,
        'end' => $peminjaman->tanggal_selesai,
        'ruangan_id' => $peminjaman->id_ruangan,
      ];
    }

    return [
      'ruangan' => $ruangan,
      'dataRuangan' => $dataRuangan,
      'events' => $events,
    ];
  }

  public function getUsedTimeSlots(string $ruanganId, string $start, ?string $end = null): array
  {
    $tanggalMulai = Carbon::parse($start);
    $tanggalSelesai = Carbon::parse($end ?? $tanggalMulai->copy()->addDays(6)->toDateString());

    $usedTimes = DB::table('peminjaman')
      ->where('id_ruangan', $ruanganId)
      ->where(function ($query) use ($tanggalMulai, $tanggalSelesai) {
        $query->whereDate('tanggal_mulai', '<=', $tanggalSelesai)
          ->whereDate('tanggal_selesai', '>=', $tanggalMulai);
      })
      ->whereIn('status', ['Disetujui', 'Selesai'])
      ->get();

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

    return $usedTimeSlots;
  }
}