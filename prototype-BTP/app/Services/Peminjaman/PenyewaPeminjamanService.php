<?php

namespace App\Services\Peminjaman;

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

    } catch (\Exception $e) {
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
    return Carbon::createFromFormat('Y-m-d H:i', $tanggal . ' ' . $jam)->addHour()->format('Y-m-d H:i:s');
  }

  public function handlePeminjaman(BasePeminjamanRequest $request): void
  {
    $role = $request->input('role');
    $tanggalMulai = $request->input('tanggal_mulai') . ' ' . $request->input('jam_mulai');
    $tanggalSelesai = '';

    $ktpUrl = null;

    if (in_array($role, ['Mahasiswa', 'Umum'])) {
      $ktpUrl = $this->uploadKtpImage($request->file('ktp_url'));

      if (!$ktpUrl) {
        throw new RuntimeException('Upload KTP gagal. Silakan coba lagi nanti.');
      }

      $tanggalSelesai = $this->calculateTanggalSelesaiMahasiswa(
        $request->input('tanggal_mulai'),
        $request->input('jam_mulai')
      );
    }

    if ($role === 'Pegawai') {
      $tanggalSelesai = $this->calculateTanggalSelesaiPegawai(
        $request->input('tanggal_selesai'),
        $request->input('jam_selesai')
      );
    }

    $this->penyewaPeminjamanRepository->createPeminjaman([
      'nama_peminjam' => $request->input('nama_peminjam'),
      'nomor_induk' => $request->input('nomor_induk'),
      'nomor_telepon' => $request->input('nomor_telepon'),
      'id_ruangan' => $request->input('id_ruangan'),
      'ktp_url' => $ktpUrl,
      'role' => $role,
      'tanggal_mulai' => $tanggalMulai,
      'tanggal_selesai' => $tanggalSelesai,
      'jumlah' => $request->input('jumlah'),
      'total_harga' => $request->input('total_harga'),
      'status' => 'Menunggu',
      'keterangan' => $request->input('keterangan') ?? '~',
    ]);
  }
}