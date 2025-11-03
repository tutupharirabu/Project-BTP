<?php

namespace App\Repositories\Peminjaman\StatusPengajuan;

use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Enums\Penyewa\StatusPenyewa;
use App\Enums\Relation\PeminjamanRelasi;
use App\Enums\StatusPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Support\Collection;
use App\Interfaces\Repositories\Peminjaman\StatusPengajuan\AdminStatusPengajuanRepositoryInterface;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;

class AdminStatusPengajuanRepository implements AdminStatusPengajuanRepositoryInterface
{
  protected function buildOverlapQuery(Peminjaman $peminjaman)
  {
    $sessions = $peminjaman->relationLoaded(PeminjamanRelasi::Sessions->value)
      ? $peminjaman->sessions
      : $peminjaman->sessions()->get();

    $query = Peminjaman::where(RuanganDatabaseColumn::IdRuangan->value, $peminjaman->id_ruangan)
      ->where(PeminjamanDatabaseColumn::IdPeminjaman->value, '!=', $peminjaman->id_peminjaman);

    if ($sessions->isNotEmpty()) {
      $query->whereHas(PeminjamanRelasi::Sessions->value, function ($builder) use ($sessions) {
        $builder->where(function ($subQuery) use ($sessions) {
          foreach ($sessions as $session) {
            $subQuery->orWhere(function ($or) use ($session) {
              $or->where('tanggal_mulai', '<', $session->tanggal_selesai)
                ->where('tanggal_selesai', '>', $session->tanggal_mulai);
            });
          }
        });
      });
    } else {
      $startColumn = PeminjamanDatabaseColumn::TanggalMulai->value;
      $endColumn = PeminjamanDatabaseColumn::TanggalSelesai->value;

      $query->where(function ($builder) use ($peminjaman, $startColumn, $endColumn) {
        $builder->where($startColumn, '<', $peminjaman->{$endColumn})
          ->where($endColumn, '>', $peminjaman->{$startColumn});
      });
    }

    return $query;
  }

  public function getConflictingBookings(Peminjaman $peminjaman): Collection
  {
    $statusMenunggu = StatusPeminjaman::Menunggu->value;

    return $this->buildOverlapQuery($peminjaman)
      ->where(PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value, $statusMenunggu)
      ->get();
  }

  protected function getApprovedNonPegawaiConflicts(Peminjaman $peminjaman): Collection
  {
    $statusDisetujui = StatusPeminjaman::Disetujui->value;
    $nonPegawaiRoles = [StatusPenyewa::Mahasiswa->value, StatusPenyewa::Umum->value];

    return $this->buildOverlapQuery($peminjaman)
      ->where(PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value, $statusDisetujui)
      ->whereIn(PeminjamanDatabaseColumn::StatusPenyewa->value, $nonPegawaiRoles)
      ->get();
  }

  public function approvePengajuan(Peminjaman $peminjaman, string $idUser): void
  {
    $statusDisetujui = StatusPeminjaman::Disetujui->value;
    $statusDitolak = StatusPeminjaman::Ditolak->value;
    $statusPegawai = StatusPenyewa::Pegawai->value;

    $conflicts = $this->getConflictingBookings($peminjaman);

    $peminjaman->status = $statusDisetujui;
    $peminjaman->id_users = $idUser;
    $peminjaman->save();

    foreach ($conflicts as $booking) {
      $booking->status = $statusDitolak;
      $booking->id_users = $idUser;
      $booking->save();
    }

    if ($peminjaman->{PeminjamanDatabaseColumn::StatusPenyewa->value} === $statusPegawai) {
      $approvedConflicts = $this->getApprovedNonPegawaiConflicts($peminjaman);

      foreach ($approvedConflicts as $booking) {
        $booking->status = $statusDitolak;
        $booking->id_users = $idUser;
        $booking->save();
      }
    }
  }

  public function rejectPengajuan(Peminjaman $peminjaman, string $idUser): void
  {
    $statusDitolak = StatusPeminjaman::Ditolak->value;

    $peminjaman->status = $statusDitolak;
    $peminjaman->id_users = $idUser;
    $peminjaman->save();
  }

  public function completePengajuan(Peminjaman $peminjaman, string $idUser): void
  {
    $statusSelesai = StatusPeminjaman::Selesai->value;

    $peminjaman->status = $statusSelesai;
    $peminjaman->id_users = $idUser;
    $peminjaman->save();
  }

  public function deletePengajuan(Peminjaman $peminjaman): void
  {
    $publicIds = [
      $peminjaman->{PeminjamanDatabaseColumn::KtpPublicId->value} ?? null,
      $peminjaman->{PeminjamanDatabaseColumn::KtmPublicId->value} ?? null,
      $peminjaman->{PeminjamanDatabaseColumn::NpwpPublicId->value} ?? null,
    ];

    foreach ($publicIds as $publicId) {
      if (!$publicId) {
        continue;
      }

      try {
        Cloudinary::destroy($publicId, ['resource_type' => 'image']);
      } catch (\Throwable $exception) {
        Log::warning('Gagal menghapus dokumen Cloudinary peminjaman', [
          'peminjaman_id' => $peminjaman->id_peminjaman,
          'public_id' => $publicId,
          'message' => $exception->getMessage(),
        ]);
      }
    }

    $peminjaman->delete();
  }
}
