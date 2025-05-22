<?php

namespace App\Interfaces\Repositories\Peminjaman;

use App\Models\Peminjaman;

interface PenyewaPeminjamanRepositoryInterface extends BasePeminjamanRepositoryInterface
{
  public function createPeminjaman(array $data): Peminjaman;
  public function existsOverlapPeminjaman(string $id_ruangan, string $tanggal_mulai, string $tanggal_selesai): bool;
  public function getGroupRuanganIdsByRuanganId(string $idRuangan): array;
  public function getUnavailableJam(string $idRuangan, string $tanggal): array;
  public function getUnavailableTanggal(string $idRuangan): array;
  public function getAvailableJamMulaiHalfday(string $id_ruangan, string $tanggal): array;
  public function getCoworkingFullyBookedDates($id_ruangan): array;
  public function getCoworkingBlockedStartDatesForBulan($id_ruangan): array;
  public function getCoworkingSeatAvailability(string $id_ruangan, string $tanggal): array;
  public function getPrivateOfficeBlockedDates(string $idRuangan): array;


}