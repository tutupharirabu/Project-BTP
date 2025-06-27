<?php

namespace App\Services\Peminjaman;

use Exception;
use Carbon\Carbon;
use RuntimeException;
use App\Models\Ruangan;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use App\Enums\Penyewa\SatuanPenyewa;
use App\Enums\Penyewa\StatusPenyewa;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Http\Requests\Peminjaman\BasePeminjamanRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Interfaces\Repositories\Ruangan\BaseRuanganRepositoryInterface;
use App\Interfaces\Repositories\Ruangan\PenyewaRuanganRepositoryInterface;
use App\Interfaces\Repositories\Peminjaman\PenyewaPeminjamanRepositoryInterface;

class PenyewaPeminjamanService
{
  protected PenyewaPeminjamanRepositoryInterface $penyewaPeminjamanRepository;
  protected PenyewaRuanganRepositoryInterface $penyewaRuanganRepository;
  protected BaseRuanganRepositoryInterface $baseRuanganRepository;

  public function __construct(PenyewaPeminjamanRepositoryInterface $penyewaPeminjamanRepositoryInterface, PenyewaRuanganRepositoryInterface $penyewaRuanganRepositoryInterface, BaseRuanganRepositoryInterface $baseRuanganRepositoryInterface)
  {
    $this->penyewaPeminjamanRepository = $penyewaPeminjamanRepositoryInterface;
    $this->penyewaRuanganRepository = $penyewaRuanganRepositoryInterface;
    $this->baseRuanganRepository = $baseRuanganRepositoryInterface;
  }

  public function getFormData(): array
  {
    return [
      'dataPeminjaman' => $this->penyewaPeminjamanRepository->getAllPeminjaman(),
      'dataRuangan' => $this->baseRuanganRepository->getAllRuangan(),
    ];
  }

  public function getDetailRuanganById(string $id): Ruangan
  {
    $ruangan = $this->baseRuanganRepository->getRuanganById($id);

    if (!$ruangan) {
      throw new NotFoundHttpException('Ruangan tidak ditemukan.');
    }

    return $ruangan;
  }

  public function getGroupRuanganIds(string $idRuangan): array
  {
    return $this->penyewaPeminjamanRepository->getGroupRuanganIdsByRuanganId($idRuangan);
  }

  public function getUnavailableJam(string $idRuangan, string $tanggal): array
  {
    return $this->penyewaPeminjamanRepository->getUnavailableJam($idRuangan, $tanggal);
  }

  public function getUnavailableTanggal(string $idRuangan): array
  {
    return $this->penyewaPeminjamanRepository->getUnavailableTanggal($idRuangan);
  }

  public function getAvailableJamMulaiHalfday(string $idRuangan, string $tanggal): array
  {
    return $this->penyewaPeminjamanRepository->getAvailableJamMulaiHalfday($idRuangan, $tanggal);
  }

  public function getPrivateOfficeBlockedDates(string $idRuangan): array
  {
    return $this->penyewaPeminjamanRepository->getPrivateOfficeBlockedDates($idRuangan);
  }

  public function getCoworkingFullyBookedDates($idRuangan): array
  {
    return $this->penyewaPeminjamanRepository->getCoworkingFullyBookedDates($idRuangan);
  }

  public function getCoworkingBlockedStartDatesForBulan($idRuangan): array
  {
    return $this->penyewaPeminjamanRepository->getCoworkingBlockedStartDatesForBulan($idRuangan);
  }

  public function uploadKtpImage(UploadedFile $image): ?string
  {
    try {
      $uploadResult = Cloudinary::upload(
        $image->getRealPath(),
        [
          'folder' => 'spacerent-btp/ktp-btp',
          'transformation' => [
            [
              'overlay' => 'text:Arial_20:Confidential-Bandung Techno Park',
              'color' => '#FF0000',
              'opacity' => 50,
              'gravity' => 'south_east',
              'x' => 10,
              'y' => 10,
            ]
          ]
        ]
      );

      return $uploadResult->getSecurePath() ?? null;

    } catch (Exception $e) {
      Log::error('Cloudinary gagal upload: ' . $e->getMessage());
      throw new RuntimeException('Gagal mengunggah gambar KTP.');
    }
  }

  public function calculateTanggalSelesaiMahasiswa(string $tanggal, string $jam): string
  {
    $durasi = '04:00';
    $durasiInMinutes = Carbon::parse($durasi)->diffInMinutes(Carbon::parse('00:00'));
    return Carbon::parse($tanggal . ' ' . $jam)->addMinutes($durasiInMinutes)->format('Y-m-d H:i:s');
  }

  public function calculateTanggalSelesaiPegawai(string $tanggal, string $jam): string
  {
    return Carbon::createFromFormat('Y-m-d H:i', $tanggal . ' ' . $jam)->format('Y-m-d H:i:s');
  }

  public function handlePeminjaman(BasePeminjamanRequest $request): void
  {
    $role = $request->input('role');
    $idRuangan = $request->input(RuanganDatabaseColumn::IdRuangan->value);
    $ruangan = $this->baseRuanganRepository->getRuanganById($idRuangan);
    $satuan = $ruangan->satuan;
    $namaRuangan = $ruangan->nama_ruangan;
    $groupId = $ruangan->group_id_ruangan ?? null;

    $statusPegawai = StatusPenyewa::Pegawai->value;
    $statusMahasiswa = StatusPenyewa::Mahasiswa->value;
    $statusUmum = StatusPenyewa::Umum->value;
    $seatPerHari = SatuanPenyewa::SeatPerHari->value;
    $seatPerBulan = SatuanPenyewa::SeatPerBulan->value;
    $statusMenunggu = 'Menunggu';

    $ktpUrl = null;
    $jumlahPeserta = $request->input(PeminjamanDatabaseColumn::JumlahPeserta->value);

    // Tentukan tanggal mulai dan selesai
    if ($role === $statusPegawai) {
      $tanggalMulai = $request->input(PeminjamanDatabaseColumn::TanggalMulai->value) . ' ' . $request->input(PeminjamanDatabaseColumn::JamMulai->value);
      $tanggalSelesai = $this->calculateTanggalSelesaiPegawai(
        $request->input(PeminjamanDatabaseColumn::TanggalSelesai->value),
        $request->input(PeminjamanDatabaseColumn::JamSelesai->value)
      );
    } elseif (in_array($role, [$statusMahasiswa, $statusUmum])) {
      $ktpUrl = $this->uploadKtpImage($request->file(PeminjamanDatabaseColumn::UrlKtp->value));
      if (!$ktpUrl) {
        throw new RuntimeException('Upload KTP gagal. Silakan coba lagi nanti.');
      }

      if (stripos($namaRuangan, 'coworking') !== false && $satuan === $seatPerHari) {
        $tanggalMulai = $request->input(PeminjamanDatabaseColumn::TanggalMulai->value) . ' 08:00:00';
        $tanggalSelesai = $request->input(PeminjamanDatabaseColumn::TanggalMulai->value) . ' 22:00:00';
      } elseif (stripos($namaRuangan, 'coworking') !== false && $satuan === $seatPerBulan) {
        $tanggalMulai = $request->input(PeminjamanDatabaseColumn::TanggalMulai->value) . ' 08:00:00';
        $tanggalSelesai = Carbon::parse($request->input(PeminjamanDatabaseColumn::TanggalMulai->value))
          ->addDays(30)
          ->format('Y-m-d') . ' 22:00:00';
      } elseif (stripos($namaRuangan, 'private') !== false && $satuan === $seatPerBulan) {
        $bulan = (int) $request->input(PeminjamanDatabaseColumn::DurasiPerBulan->value);
        $tanggalMulai = $request->input(PeminjamanDatabaseColumn::TanggalMulai->value) . ' 08:00:00';
        $tanggalSelesai = Carbon::parse($request->input(PeminjamanDatabaseColumn::TanggalMulai->value))
          ->addMonths($bulan)
          ->subDay()
          ->format('Y-m-d') . ' 22:00:00';
      } else {
        // Default (Halfday / 4 Jam)
        $tanggalMulai = $request->input(PeminjamanDatabaseColumn::TanggalMulai->value) . ' ' . $request->input(PeminjamanDatabaseColumn::JamMulai->value);
        $tanggalSelesai = $this->calculateTanggalSelesaiMahasiswa(
          $request->input(PeminjamanDatabaseColumn::TanggalMulai->value),
          $request->input(PeminjamanDatabaseColumn::JamMulai->value)
        );
      }
    } else {
      throw new RuntimeException('Role tidak valid.');
    }

    // Validasi: Coworking seat (hari/bulan) harus cek seat seluruh group
    $isCoworkingSeatHarian = stripos($namaRuangan, 'coworking') !== false && $satuan === $seatPerHari;
    $isCoworkingSeatBulanan = stripos($namaRuangan, 'coworking') !== false && $satuan === $seatPerBulan;

    // === Validasi overlap (bukan coworking seat/hari) ===
    if (!($isCoworkingSeatHarian || $isCoworkingSeatBulanan)) {
      if (
        $this->penyewaPeminjamanRepository->existsOverlapPeminjaman(
          $idRuangan,
          $tanggalMulai,
          $tanggalSelesai
        )
      ) {
        throw new RuntimeException('Ruangan sudah dibooking pada waktu tersebut. Silakan pilih waktu lain.');
      }
    }

    // === Validasi seat coworking (gabungan semua id_ruangan satu group) ===
    if ($isCoworkingSeatHarian || $isCoworkingSeatBulanan) {
      if ($groupId) {
        $ruanganGroupIds = $this->penyewaRuanganRepository->getRuanganByGroupId($groupId)
          ->pluck(RuanganDatabaseColumn::IdRuangan->value)->toArray();
      } else {
        $ruanganGroupIds = [$idRuangan];
      }
      $sisaSeatData = $this->penyewaPeminjamanRepository->getCoworkingSeatAvailability(
        $ruanganGroupIds,
        $request->input(PeminjamanDatabaseColumn::TanggalMulai->value)
      );
      $sisa_seat = $sisaSeatData['sisa_seat'] ?? 0;

      if ($jumlahPeserta > $sisa_seat) {
        throw new RuntimeException('Jumlah peserta melebihi sisa seat. Tersisa hanya ' . $sisa_seat . ' kursi.');
      }
    }

    // Create booking
    $this->penyewaPeminjamanRepository->createPeminjaman([
      'nama_peminjam' => $request->input(PeminjamanDatabaseColumn::NamaPenyewa->value),
      'nomor_induk' => $request->input(PeminjamanDatabaseColumn::NomorIndukPenyewa->value),
      'nomor_telepon' => $request->input(PeminjamanDatabaseColumn::NomorTeleponPenyewa->value),
      'id_ruangan' => $idRuangan,
      'ktp_url' => $ktpUrl,
      'role' => $role,
      'tanggal_mulai' => $tanggalMulai,
      'tanggal_selesai' => $tanggalSelesai,
      'jumlah' => $jumlahPeserta,
      'total_harga' => $request->input(PeminjamanDatabaseColumn::TotalHarga->value),
      'status' => $statusMenunggu,
      'keterangan' => $request->input(PeminjamanDatabaseColumn::KeteranganPenyewaan->value) ?? '~',
    ]);
  }
}