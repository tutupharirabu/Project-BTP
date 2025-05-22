<?php

namespace App\Services\Peminjaman;

use Exception;
use Carbon\Carbon;
use RuntimeException;
use App\Models\Ruangan;
use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Peminjaman\BasePeminjamanRequest;
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
      $cloudinary = new Cloudinary();

      $uploadResult = $cloudinary->uploadApi()->upload($image->getRealPath(), [
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
      ]);

      return $uploadResult['secure_url'] ?? null;

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
    $idRuangan = $request->input('id_ruangan');
    $ruangan = $this->baseRuanganRepository->getRuanganById($idRuangan);
    $satuan = $ruangan->satuan;
    $namaRuangan = $ruangan->nama_ruangan;
    $groupId = $ruangan->group_id_ruangan ?? null;

    $ktpUrl = null;
    $jumlahPeserta = $request->input('jumlah');

    // Tentukan tanggal mulai dan selesai
    if ($role === 'Pegawai') {
      $tanggalMulai = $request->input('tanggal_mulai') . ' ' . $request->input('jam_mulai');
      $tanggalSelesai = $this->calculateTanggalSelesaiPegawai(
        $request->input('tanggal_selesai'),
        $request->input('jam_selesai')
      );
    } elseif (in_array($role, ['Mahasiswa', 'Umum'])) {
      $ktpUrl = $this->uploadKtpImage($request->file('ktp_url'));
      if (!$ktpUrl) {
        throw new RuntimeException('Upload KTP gagal. Silakan coba lagi nanti.');
      }

      if (stripos($namaRuangan, 'coworking') !== false && $satuan === 'Seat / Hari') {
        $tanggalMulai = $request->input('tanggal_mulai') . ' 08:00:00';
        $tanggalSelesai = $request->input('tanggal_mulai') . ' 22:00:00';
      } elseif (stripos($namaRuangan, 'coworking') !== false && $satuan === 'Seat / Bulan') {
        $tanggalMulai = $request->input('tanggal_mulai') . ' 08:00:00';
        $tanggalSelesai = Carbon::parse($request->input('tanggal_mulai'))
          ->addDays(30)
          ->format('Y-m-d') . ' 22:00:00';
      } elseif (stripos($namaRuangan, 'private') !== false && $satuan === 'Seat / Bulan') {
        $bulan = (int) $request->input('durasi_bulan');
        $tanggalMulai = $request->input('tanggal_mulai') . ' 08:00:00';
        $tanggalSelesai = Carbon::parse($request->input('tanggal_mulai'))
          ->addMonths($bulan)
          ->subDay()
          ->format('Y-m-d') . ' 22:00:00';
      } else {
        // Default (Halfday / 4 Jam)
        $tanggalMulai = $request->input('tanggal_mulai') . ' ' . $request->input('jam_mulai');
        $tanggalSelesai = $this->calculateTanggalSelesaiMahasiswa(
          $request->input('tanggal_mulai'),
          $request->input('jam_mulai')
        );
      }
    } else {
      throw new RuntimeException('Role tidak valid.');
    }

    // Validasi: Coworking seat (hari/bulan) harus cek seat seluruh group
    $isCoworkingSeatHarian = stripos($namaRuangan, 'coworking') !== false && $satuan === 'Seat / Hari';
    $isCoworkingSeatBulanan = stripos($namaRuangan, 'coworking') !== false && $satuan === 'Seat / Bulan';

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
          ->pluck('id_ruangan')->toArray();
      } else {
        $ruanganGroupIds = [$idRuangan];
      }
      $sisaSeatData = $this->penyewaPeminjamanRepository->getCoworkingSeatAvailability(
        $ruanganGroupIds,
        $request->input('tanggal_mulai')
      );
      $sisa_seat = $sisaSeatData['sisa_seat'] ?? 0;

      if ($jumlahPeserta > $sisa_seat) {
        throw new RuntimeException('Jumlah peserta melebihi sisa seat. Tersisa hanya ' . $sisa_seat . ' kursi.');
      }
    }

    // Create booking
    $this->penyewaPeminjamanRepository->createPeminjaman([
      'nama_peminjam' => $request->input('nama_peminjam'),
      'nomor_induk' => $request->input('nomor_induk'),
      'nomor_telepon' => $request->input('nomor_telepon'),
      'id_ruangan' => $idRuangan,
      'ktp_url' => $ktpUrl,
      'role' => $role,
      'tanggal_mulai' => $tanggalMulai,
      'tanggal_selesai' => $tanggalSelesai,
      'jumlah' => $jumlahPeserta,
      'total_harga' => $request->input('total_harga'),
      'status' => 'Menunggu',
      'keterangan' => $request->input('keterangan') ?? '~',
    ]);
  }
}