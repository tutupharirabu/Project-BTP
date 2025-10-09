<?php

namespace App\Repositories\Ruangan;

use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Enums\Relation\PeminjamanRelasi;
use App\Enums\StatusPeminjaman;
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
    $relasiRuangan = PeminjamanRelasi::Ruangan->value;
    $columnIdRuangan = RuanganDatabaseColumn::IdRuangan->value;
    $columnStatusPeminjaman = PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value;
    $statusDisetujui = StatusPeminjaman::Disetujui->value;
    $statusSelesai = StatusPeminjaman::Selesai->value;

    $relations = [$relasiRuangan, PeminjamanRelasi::Sessions->value];

    return Peminjaman::with($relations)
      ->where($columnIdRuangan, $idRuangan)
      ->whereIn($columnStatusPeminjaman, [$statusDisetujui, $statusSelesai])
      ->get();
  }

  public function getRuanganByGroupId(string $groupId): Collection
  {
    $columnGroupIdRuangan = RuanganDatabaseColumn::GroupIdRuangan->value;
    return Ruangan::where($columnGroupIdRuangan, $groupId)->get();
  }

  public function getCoworkingWeeklySeatStatus(string $idRuangan, string $tanggalMulai, string $tanggalSelesai): array
  {
    $columnGroupIdRuangan = RuanganDatabaseColumn::GroupIdRuangan->value;
    $columnKapasitasMaksimal = RuanganDatabaseColumn::KapasitasMaksimal->value;
    $relasiRuangan = PeminjamanRelasi::Ruangan->value;
    $columnStatusPeminjaman = PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value;
    $statusDisetujui = StatusPeminjaman::Disetujui->value;
    $columnTanggalMulai = PeminjamanDatabaseColumn::TanggalMulai->value;
    $columnTanggalSelesai = PeminjamanDatabaseColumn::TanggalSelesai->value;
    $columnJumlahPeserta = PeminjamanDatabaseColumn::JumlahPeserta->value;

    $ruangan = Ruangan::findOrFail($idRuangan);
    $groupId = $ruangan->group_id_ruangan;

    // Cari kapasitas minimal dari semua ruangan dalam group
    $minKapasitas = Ruangan::where($columnGroupIdRuangan, $groupId)->min($columnKapasitasMaksimal);

    $result = [];
    $period = new DatePeriod(
      new DateTime($tanggalMulai),
      new DateInterval('P1D'),
      (new DateTime($tanggalSelesai))->modify('+1 day')
    );

    foreach ($period as $date) {
      $tanggal = $date->format('Y-m-d');

      // Sum jumlah semua peminjaman yang tanggalnya overlap pada tanggal ini
      $booked = Peminjaman::whereHas($relasiRuangan, function ($q) use ($groupId, $columnGroupIdRuangan) {
        $q->where($columnGroupIdRuangan, $groupId);
      })
        ->where($columnStatusPeminjaman, $statusDisetujui)
        ->whereDate($columnTanggalMulai, '<=', $tanggal)
        ->whereDate($columnTanggalSelesai, '>=', $tanggal)
        ->sum($columnJumlahPeserta);

      $sisa_seat = max(0, $minKapasitas - $booked);
      $result[] = ['tanggal' => $tanggal, 'sisa_seat' => $sisa_seat];
    }
    return $result;
  }
}
