<?php

namespace App\Services\Ruangan;

use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Enums\Relation\PeminjamanRelasi;
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
      $sessions = $peminjaman->relationLoaded(PeminjamanRelasi::Sessions->value)
        ? $peminjaman->sessions
        : $peminjaman->sessions()->get();

      if ($sessions->isEmpty()) {
        $events[] = [
          'title' => $peminjaman->nama_peminjam . " - " . $peminjaman->ruangan->nama_ruangan,
          'peminjam' => $peminjaman->nama_peminjam,
          'ruangan' => $peminjaman->ruangan->nama_ruangan,
          'start' => Carbon::parse($peminjaman->tanggal_mulai)->timezone(config('app.timezone'))->format('Y-m-d H:i:s'),
          'end' => Carbon::parse($peminjaman->tanggal_selesai)->timezone(config('app.timezone'))->format('Y-m-d H:i:s'),
          'ruangan_id' => $peminjaman->id_ruangan,
        ];
        continue;
      }

      foreach ($sessions as $session) {
        $events[] = [
          'title' => $peminjaman->nama_peminjam . " - " . $peminjaman->ruangan->nama_ruangan,
          'peminjam' => $peminjaman->nama_peminjam,
          'ruangan' => $peminjaman->ruangan->nama_ruangan,
          'start' => Carbon::parse($session->tanggal_mulai)->timezone(config('app.timezone'))->format('Y-m-d H:i:s'),
          'end' => Carbon::parse($session->tanggal_selesai)->timezone(config('app.timezone'))->format('Y-m-d H:i:s'),
          'ruangan_id' => $peminjaman->id_ruangan,
        ];
      }
    }

    return [
      'ruangan' => $ruangan,
      'dataRuangan' => $dataRuangan,
      'events' => $events,
    ];
  }

  public function getUsedTimeSlots(string $ruanganId, string $start, ?string $end = null): array
  {
    $peminjamanTable = PeminjamanDatabaseColumn::Peminjaman->value;
    $idRuanganColumn = RuanganDatabaseColumn::IdRuangan->value;
    $tanggalMulaiColumn = PeminjamanDatabaseColumn::TanggalMulai->value;
    $tanggalSelesaiColumn = PeminjamanDatabaseColumn::TanggalSelesai->value;
    $statusPeminjamanColumn = PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value;
    $statusDisetujui = StatusPeminjaman::Disetujui->value;

    $tanggalMulai = Carbon::parse($start);
    $tanggalSelesai = Carbon::parse($end ?? $tanggalMulai->copy()->addDays(6)->toDateString());

    $sessionTable = 'peminjaman_sessions';

    $usedTimes = DB::table($sessionTable)
      ->join($peminjamanTable, $peminjamanTable . '.' . PeminjamanDatabaseColumn::IdPeminjaman->value, '=', $sessionTable . '.peminjaman_id')
      ->where($peminjamanTable . '.' . $idRuanganColumn, $ruanganId)
      ->where($peminjamanTable . '.' . $statusPeminjamanColumn, $statusDisetujui)
      ->where(function ($query) use ($sessionTable, $tanggalMulai, $tanggalSelesai) {
        $query->whereDate($sessionTable . '.tanggal_mulai', '<=', $tanggalSelesai)
          ->whereDate($sessionTable . '.tanggal_selesai', '>=', $tanggalMulai);
      })
      ->get([
        $sessionTable . '.tanggal_mulai as tanggal_mulai',
        $sessionTable . '.tanggal_selesai as tanggal_selesai',
      ]);

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
