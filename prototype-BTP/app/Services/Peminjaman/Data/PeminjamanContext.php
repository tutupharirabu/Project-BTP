<?php

namespace App\Services\Peminjaman\Data;

use RuntimeException;
use App\Models\Ruangan;
use App\Enums\Penyewa\SatuanPenyewa;
use App\Enums\Penyewa\StatusPenyewa;
use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Http\Requests\Peminjaman\BasePeminjamanRequest;

class PeminjamanContext
{
  private const STATUS_MENUNGGU = 'Menunggu';

  private string $role;
  private Ruangan $ruangan;
  private string $idRuangan;
  private ?string $groupId;
  private string $namaRuangan;
  private string $satuan;
  private int $jumlahPeserta;
  private int $jumlahSesi;
  private string $keteranganBase;
  private float $totalHargaForm;
  private string $namaPeminjam;
  private string $nomorInduk;
  private string $nomorTelepon;
  private string $tanggalMulaiInput;

  private function __construct()
  {
  }

  public static function fromRequest(BasePeminjamanRequest $request, Ruangan $ruangan): self
  {
    $context = new self();

    $context->role = (string) $request->input('role');
    $allowedRoles = [
      StatusPenyewa::Pegawai->value,
      StatusPenyewa::Mahasiswa->value,
      StatusPenyewa::Umum->value,
    ];

    if (!in_array($context->role, $allowedRoles, true)) {
      throw new RuntimeException('Role tidak valid.');
    }

    $context->ruangan = $ruangan;
    $context->idRuangan = (string) $request->input(RuanganDatabaseColumn::IdRuangan->value);
    $context->groupId = $ruangan->group_id_ruangan ?? null;
    $context->namaRuangan = (string) $ruangan->nama_ruangan;
    $context->satuan = (string) $ruangan->satuan;

    $context->jumlahPeserta = (int) $request->input(PeminjamanDatabaseColumn::JumlahPeserta->value);
    $jumlahSesi = (int) $request->input('jumlah_sesi', 1);
    $context->jumlahSesi = $jumlahSesi > 0 ? $jumlahSesi : 1;

    $keterangan = $request->input(PeminjamanDatabaseColumn::KeteranganPenyewaan->value);
    $context->keteranganBase = $keterangan !== null && trim($keterangan) !== '' ? $keterangan : '~';

    $context->totalHargaForm = (float) $request->input(PeminjamanDatabaseColumn::TotalHarga->value, 0);

    $context->namaPeminjam = (string) $request->input(PeminjamanDatabaseColumn::NamaPenyewa->value);
    $context->nomorInduk = (string) $request->input(PeminjamanDatabaseColumn::NomorIndukPenyewa->value);
    $context->nomorTelepon = (string) $request->input(PeminjamanDatabaseColumn::NomorTeleponPenyewa->value);
    $context->tanggalMulaiInput = (string) $request->input(PeminjamanDatabaseColumn::TanggalMulai->value);

    return $context;
  }

  public function role(): string
  {
    return $this->role;
  }

  public function ruangan(): Ruangan
  {
    return $this->ruangan;
  }

  public function idRuangan(): string
  {
    return $this->idRuangan;
  }

  public function groupId(): ?string
  {
    return $this->groupId;
  }

  public function namaRuangan(): string
  {
    return $this->namaRuangan;
  }

  public function satuan(): string
  {
    return $this->satuan;
  }

  public function jumlahPeserta(): int
  {
    return $this->jumlahPeserta;
  }

  public function jumlahSesi(): int
  {
    return $this->jumlahSesi;
  }

  public function keteranganBase(): string
  {
    return $this->keteranganBase;
  }

  public function totalHargaForm(): float
  {
    return $this->totalHargaForm;
  }

  public function namaPeminjam(): string
  {
    return $this->namaPeminjam;
  }

  public function nomorInduk(): string
  {
    return $this->nomorInduk;
  }

  public function nomorTelepon(): string
  {
    return $this->nomorTelepon;
  }

  public function tanggalMulaiInput(): string
  {
    return $this->tanggalMulaiInput;
  }

  public function statusMenunggu(): string
  {
    return self::STATUS_MENUNGGU;
  }

  public function isPegawai(): bool
  {
    return $this->role === StatusPenyewa::Pegawai->value;
  }

  public function isMahasiswa(): bool
  {
    return $this->role === StatusPenyewa::Mahasiswa->value;
  }

  public function isUmum(): bool
  {
    return $this->role === StatusPenyewa::Umum->value;
  }

  public function isCoworkingSeatHarian(): bool
  {
    return stripos($this->namaRuangan, 'coworking') !== false
      && $this->satuan === SatuanPenyewa::SeatPerHari->value;
  }

  public function isCoworkingSeatBulanan(): bool
  {
    return stripos($this->namaRuangan, 'coworking') !== false
      && $this->satuan === SatuanPenyewa::SeatPerBulan->value;
  }

  public function isPrivateOfficeBulanan(): bool
  {
    return stripos($this->namaRuangan, 'private') !== false
      && $this->satuan === SatuanPenyewa::SeatPerBulan->value;
  }

  public function shouldCheckOverlap(): bool
  {
    return !$this->isPegawai() && !$this->requiresSeatValidation();
  }

  public function requiresSeatValidation(): bool
  {
    return $this->isCoworkingSeatHarian() || $this->isCoworkingSeatBulanan();
  }
}
