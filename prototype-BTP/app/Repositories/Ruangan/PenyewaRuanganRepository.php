<?php

namespace App\Repositories\Ruangan;

use DateTime;
use DatePeriod;
use DateInterval;
use App\Models\Ruangan;
use App\Models\Peminjaman;
use Illuminate\Support\Collection;
use App\Interfaces\Repositories\Ruangan\PenyewaRuanganRepositoryInterface;

class PenyewaRuanganRepository implements PenyewaRuanganRepositoryInterface
{
  public function getApprovedPeminjamanRuangan(string $idRuangan)
  {
    return Peminjaman::with('ruangan')
      ->where('id_ruangan', $idRuangan)
      ->whereIn('status', ['Disetujui', 'Selesai'])
      ->get();
  }

  public function getRuanganByGroupId(string $groupId): Collection
  {
    return Ruangan::where('group_id_ruangan', $groupId)->get();
  }

  public function getCoworkingWeeklySeatStatus(string $idRuangan, string $tanggalMulai, string $tanggalSelesai): array
  {
    $ruangan = Ruangan::findOrFail($idRuangan);
    $groupId = $ruangan->group_id_ruangan;

    // Cari kapasitas minimal dari semua ruangan dalam group
    $minKapasitas = Ruangan::where('group_id_ruangan', $groupId)->min('kapasitas_maksimal');

    $result = [];
    $period = new DatePeriod(
      new DateTime($tanggalMulai),
      new DateInterval('P1D'),
      (new DateTime($tanggalSelesai))->modify('+1 day')
    );

    foreach ($period as $date) {
      $tanggal = $date->format('Y-m-d');

      // Sum jumlah semua peminjaman yang tanggalnya overlap pada tanggal ini
      $booked = Peminjaman::whereHas('ruangan', function ($q) use ($groupId) {
        $q->where('group_id_ruangan', $groupId);
      })
        ->where('status', 'Disetujui')
        ->whereDate('tanggal_mulai', '<=', $tanggal)
        ->whereDate('tanggal_selesai', '>=', $tanggal)
        ->sum('jumlah');

      $sisa_seat = max(0, $minKapasitas - $booked);
      $result[] = ['tanggal' => $tanggal, 'sisa_seat' => $sisa_seat];
    }
    return $result;
  }
}