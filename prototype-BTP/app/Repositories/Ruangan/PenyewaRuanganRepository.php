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
    return Peminjaman::with(PeminjamanRelasi::Ruangan->value)
      ->where(RuanganDatabaseColumn::IdRuangan->value, $idRuangan)
      ->whereIn(PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value, [StatusPeminjaman::Disetujui->value, StatusPeminjaman::Selesai->value])
      ->get();
  }

  public function getRuanganByGroupId(string $groupId): Collection
  {
    return Ruangan::where(RuanganDatabaseColumn::GroupIdRuangan->value, $groupId)->get();
  }

  public function getCoworkingWeeklySeatStatus(string $idRuangan, string $tanggalMulai, string $tanggalSelesai): array
  {
    $ruangan = Ruangan::findOrFail($idRuangan);
    $groupId = $ruangan->group_id_ruangan;

    // Cari kapasitas minimal dari semua ruangan dalam group
    $minKapasitas = Ruangan::where(RuanganDatabaseColumn::GroupIdRuangan->value, $groupId)->min(RuanganDatabaseColumn::KapasitasMaksimal->value);

    $result = [];
    $period = new DatePeriod(
      new DateTime($tanggalMulai),
      new DateInterval('P1D'),
      (new DateTime($tanggalSelesai))->modify('+1 day')
    );

    foreach ($period as $date) {
      $tanggal = $date->format('Y-m-d');

      // Sum jumlah semua peminjaman yang tanggalnya overlap pada tanggal ini
      $booked = Peminjaman::whereHas(PeminjamanRelasi::Ruangan->value, function ($q) use ($groupId) {
        $q->where(RuanganDatabaseColumn::GroupIdRuangan->value, $groupId);
      })
        ->where(PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value, StatusPeminjaman::Disetujui->value)
        ->whereDate(PeminjamanDatabaseColumn::TanggalMulai->value, '<=', $tanggal)
        ->whereDate(PeminjamanDatabaseColumn::TanggalSelesai->value, '>=', $tanggal)
        ->sum(PeminjamanDatabaseColumn::JumlahPeserta->value);

      $sisa_seat = max(0, $minKapasitas - $booked);
      $result[] = ['tanggal' => $tanggal, 'sisa_seat' => $sisa_seat];
    }
    return $result;
  }
}