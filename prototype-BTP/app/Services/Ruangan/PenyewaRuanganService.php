<?php

namespace App\Services\Ruangan;

use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Enums\StatusPeminjaman;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Interfaces\Repositories\Ruangan\BaseRuanganRepositoryInterface;
use App\Interfaces\Repositories\Ruangan\PenyewaRuanganRepositoryInterface;

class PenyewaRuanganService
{
  protected PenyewaRuanganRepositoryInterface $penyewaRuanganRepository;
  protected BaseRuanganRepositoryInterface $baseRuanganRepository;

  public function __construct(PenyewaRuanganRepositoryInterface $penyewaRuanganRepositoryInterface, BaseRuanganRepositoryInterface $baseRuanganRepositoryInterface)
  {
    $this->penyewaRuanganRepository = $penyewaRuanganRepositoryInterface;
    $this->baseRuanganRepository = $baseRuanganRepositoryInterface;
  }

  public function getRuanganDetailWithEvents(string $id): array
  {
    $ruangan = $this->baseRuanganRepository->getRuanganById($id);
    if (!$ruangan) {
      throw new Exception('Ruangan tidak ditemukan');
    }

    $dataRuangan = $this->baseRuanganRepository->getAllRuangan();
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

    $usedTimes = DB::table(PeminjamanDatabaseColumn::Peminjaman->value)
      ->where(RuanganDatabaseColumn::IdRuangan->value, $ruanganId)
      ->where(function ($query) use ($tanggalMulai, $tanggalSelesai) {
        $query->whereDate(PeminjamanDatabaseColumn::TanggalMulai->value, '<=', $tanggalSelesai)
          ->whereDate(PeminjamanDatabaseColumn::TanggalSelesai->value, '>=', $tanggalMulai);
      })
      ->whereIn(PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value, [StatusPeminjaman::Disetujui->value])
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

  public function getCoworkingWeeklySeatStatus(string $idRuangan, string $tanggalMulai, string $tanggalSelesai): array
  {
    return $this->penyewaRuanganRepository->getCoworkingWeeklySeatStatus($idRuangan, $tanggalMulai, $tanggalSelesai);
  }
}