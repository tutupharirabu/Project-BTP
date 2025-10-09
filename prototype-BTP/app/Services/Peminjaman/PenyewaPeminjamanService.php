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

  public function uploadDocument(UploadedFile $image, string $folder): array
  {
    try {
      $uploadResult = Cloudinary::upload(
        $image->getRealPath(),
        [
          'folder' => 'spacerent-btp/' . $folder,
          'access_mode' => 'authenticated',
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

      return [
        'url' => $uploadResult->getSecurePath() ?? null,
        'public_id' => $uploadResult->getPublicId(),
        'format' => method_exists($uploadResult, 'getExtension') ? $uploadResult->getExtension() : ($uploadResult['format'] ?? null),
      ];

    } catch (Exception $e) {
      Log::error('Cloudinary gagal upload: ' . $e->getMessage());
      throw new RuntimeException('Gagal mengunggah dokumen.');
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

    $jumlahPeserta = (int) $request->input(PeminjamanDatabaseColumn::JumlahPeserta->value);
    $jumlahSesi = (int) $request->input('jumlah_sesi', 1);
    $jumlahSesi = $jumlahSesi > 0 ? $jumlahSesi : 1;
    $keteranganBase = $request->input(PeminjamanDatabaseColumn::KeteranganPenyewaan->value) ?? '~';
    $totalHargaForm = (float) $request->input(PeminjamanDatabaseColumn::TotalHarga->value, 0);

    $ktpUrl = null;
    $ktmUrl = null;
    $npwpUrl = null;
    $ktpPublicId = null;
    $ktpFormat = null;
    $ktmPublicId = null;
    $ktmFormat = null;
    $npwpPublicId = null;
    $npwpFormat = null;
    $bookingEntries = [];

    $isCoworkingSeatHarian = stripos($namaRuangan, 'coworking') !== false && $satuan === $seatPerHari;
    $isCoworkingSeatBulanan = stripos($namaRuangan, 'coworking') !== false && $satuan === $seatPerBulan;

    if ($role === $statusPegawai) {
      $tanggalMulaiInput = $request->input(PeminjamanDatabaseColumn::TanggalMulai->value);
      $jamMulaiInput = $request->input(PeminjamanDatabaseColumn::JamMulai->value);
      $tanggalMulai = Carbon::parse($tanggalMulaiInput . ' ' . $jamMulaiInput)->format('Y-m-d H:i:s');
      $tanggalSelesai = $this->calculateTanggalSelesaiPegawai(
        $request->input(PeminjamanDatabaseColumn::TanggalSelesai->value),
        $request->input(PeminjamanDatabaseColumn::JamSelesai->value)
      );

      $bookingEntries[] = [
        'start' => $tanggalMulai,
        'end' => $tanggalSelesai,
        'session_start' => $jamMulaiInput,
      ];
    } elseif (in_array($role, [$statusMahasiswa, $statusUmum])) {
      $ktpUpload = $this->uploadDocument($request->file(PeminjamanDatabaseColumn::UrlKtp->value), 'ktp-btp');
      if (empty($ktpUpload['url']) || empty($ktpUpload['public_id'])) {
        throw new RuntimeException('Upload KTP gagal. Silakan coba lagi nanti.');
      }
      $ktpUrl = $ktpUpload['url'];
      $ktpPublicId = $ktpUpload['public_id'];
      $ktpFormat = $ktpUpload['format'];

      if ($role === $statusMahasiswa) {
        $ktmFile = $request->file(PeminjamanDatabaseColumn::UrlKtm->value);
        $ktmUpload = $ktmFile ? $this->uploadDocument($ktmFile, 'ktm-btp') : null;
        if (!$ktmUpload || empty($ktmUpload['url']) || empty($ktmUpload['public_id'])) {
          throw new RuntimeException('Upload KTM gagal. Silakan coba lagi nanti.');
        }
        $ktmUrl = $ktmUpload['url'];
        $ktmPublicId = $ktmUpload['public_id'];
        $ktmFormat = $ktmUpload['format'];
      }

      if ($role === $statusUmum && $request->hasFile(PeminjamanDatabaseColumn::UrlNpwp->value)) {
        $npwpFile = $request->file(PeminjamanDatabaseColumn::UrlNpwp->value);
        $npwpUpload = $npwpFile ? $this->uploadDocument($npwpFile, 'npwp-btp') : null;
        if ($npwpUpload && !empty($npwpUpload['public_id'])) {
          $npwpUrl = $npwpUpload['url'];
          $npwpPublicId = $npwpUpload['public_id'];
          $npwpFormat = $npwpUpload['format'];
        }
      }

      $tanggalMulaiInput = $request->input(PeminjamanDatabaseColumn::TanggalMulai->value);

      if ($isCoworkingSeatHarian) {
        $bookingEntries[] = [
          'start' => $tanggalMulaiInput . ' 08:00:00',
          'end' => $tanggalMulaiInput . ' 22:00:00',
          'session_start' => '08:00',
        ];
      } elseif ($isCoworkingSeatBulanan) {
        $tanggalMulai = $tanggalMulaiInput . ' 08:00:00';
        $tanggalSelesai = Carbon::parse($tanggalMulaiInput)
          ->addDays(30)
          ->format('Y-m-d') . ' 22:00:00';

        $bookingEntries[] = [
          'start' => $tanggalMulai,
          'end' => $tanggalSelesai,
          'session_start' => '08:00',
        ];
      } elseif (stripos($namaRuangan, 'private') !== false && $satuan === $seatPerBulan) {
        $bulan = (int) $request->input(PeminjamanDatabaseColumn::DurasiPerBulan->value);
        $bulan = $bulan > 0 ? $bulan : 1;

        $tanggalMulai = $tanggalMulaiInput . ' 08:00:00';
        $tanggalSelesai = Carbon::parse($tanggalMulaiInput)
          ->addMonths($bulan)
          ->subDay()
          ->format('Y-m-d') . ' 22:00:00';

        $bookingEntries[] = [
          'start' => $tanggalMulai,
          'end' => $tanggalSelesai,
          'session_start' => '08:00',
        ];
      } else {
        $sessions = $request->input('jam_mulai_sessions', []);
        if (!is_array($sessions)) {
          $sessions = [$sessions];
        }
        $sessions = array_values(array_unique(array_filter($sessions)));
        if (empty($sessions)) {
          $sessions = [$request->input(PeminjamanDatabaseColumn::JamMulai->value)];
        }
        sort($sessions);

        if ($jumlahSesi && count($sessions) !== $jumlahSesi) {
          throw new RuntimeException('Jumlah sesi yang dipilih tidak sesuai.');
        }

        foreach ($sessions as $sessionStart) {
          $start = Carbon::parse($tanggalMulaiInput . ' ' . $sessionStart)->format('Y-m-d H:i:s');
          $end = $this->calculateTanggalSelesaiMahasiswa($tanggalMulaiInput, $sessionStart);

          $bookingEntries[] = [
            'start' => $start,
            'end' => $end,
            'session_start' => $sessionStart,
          ];
        }
      }
    } else {
      throw new RuntimeException('Role tidak valid.');
    }

    if (empty($bookingEntries)) {
      throw new RuntimeException('Tidak ada sesi peminjaman yang dipilih.');
    }

    $shouldCheckOverlap = !($isCoworkingSeatHarian || $isCoworkingSeatBulanan);
    if ($role === $statusPegawai) {
      $shouldCheckOverlap = false;
    }

    if ($shouldCheckOverlap) {
      foreach ($bookingEntries as $entry) {
        if (
          $this->penyewaPeminjamanRepository->existsOverlapPeminjaman(
            $idRuangan,
            $entry['start'],
            $entry['end']
          )
        ) {
          $startTime = Carbon::parse($entry['start'])->format('H:i');
          throw new RuntimeException('Ruangan sudah dibooking pada sesi ' . $startTime . '. Silakan pilih waktu lain.');
        }
      }
    }

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
      $sisaSeat = $sisaSeatData['sisa_seat'] ?? 0;

      if ($jumlahPeserta > $sisaSeat) {
        throw new RuntimeException('Jumlah peserta melebihi sisa seat. Tersisa hanya ' . $sisaSeat . ' kursi.');
      }
    }

    usort($bookingEntries, function ($a, $b) {
      return strcmp($a['start'], $b['start']);
    });

    $totalHargaForm = round(max(0, $totalHargaForm));
    $entryCount = count($bookingEntries);

    $entryAmounts = [];
    $remainingTotal = $totalHargaForm;
    if ($entryCount > 0) {
      for ($i = 0; $i < $entryCount; $i++) {
        $entriesLeft = $entryCount - $i;
        $portion = $entriesLeft > 0 ? intdiv($remainingTotal, $entriesLeft) : 0;
        $entryAmounts[$i] = $portion;
        $remainingTotal -= $portion;
      }
      if ($remainingTotal > 0) {
        $entryAmounts[$entryCount - 1] = ($entryAmounts[$entryCount - 1] ?? 0) + $remainingTotal;
      }
    }

    $halfdayOrder = [
      '08:00' => 0,
      '13:00' => 1,
      '18:00' => 2,
    ];

    $indexedEntries = [];
    foreach ($bookingEntries as $index => $entry) {
      $indexedEntries[] = [
        'entry' => $entry,
        'index' => $index,
      ];
    }

    $groupedEntries = [];
    $currentGroup = [];
    $previousOrder = null;

    foreach ($indexedEntries as $item) {
      $entryOrder = null;
      $sessionStart = $item['entry']['session_start'] ?? null;
      if ($sessionStart !== null && array_key_exists($sessionStart, $halfdayOrder)) {
        $entryOrder = $halfdayOrder[$sessionStart];
      }

      $shouldStartNewGroup = false;
      if (empty($currentGroup)) {
        $shouldStartNewGroup = true;
      } else {
        $isContiguousHalfday = $entryOrder !== null && $previousOrder !== null && $entryOrder === $previousOrder + 1;
        if (!$isContiguousHalfday) {
          $groupedEntries[] = $currentGroup;
          $currentGroup = [];
          $shouldStartNewGroup = true;
        }
      }

      if ($shouldStartNewGroup) {
        $currentGroup = [];
      }

      $currentGroup[] = $item;
      $previousOrder = $entryOrder;
    }

    if (!empty($currentGroup)) {
      $groupedEntries[] = $currentGroup;
    }

    foreach ($groupedEntries as $group) {
      $groupEntries = array_column($group, 'entry');
      $groupIndices = array_column($group, 'index');

      $groupStart = $groupEntries[0]['start'];
      $groupEnd = collect($groupEntries)->max(fn ($entry) => $entry['end']);

      $groupSessionLabels = collect($groupEntries)->map(function ($entry) {
        $startLabel = Carbon::parse($entry['start'])->format('H:i');
        $endLabel = Carbon::parse($entry['end'])->format('H:i');
        return 'Jadwal ' . $startLabel . ' - ' . $endLabel;
      })->values()->all();

      $groupKeterangan = $keteranganBase;
      $shouldAppendGroupSlots = count($groupSessionLabels) > 1;
      if ($shouldAppendGroupSlots) {
        if ($groupKeterangan === '~' || trim($groupKeterangan) === '') {
          $groupKeterangan = implode(' | ', $groupSessionLabels);
        } else {
          $groupKeterangan .= ' | ' . implode(' | ', $groupSessionLabels);
        }
      } elseif (!empty($groupSessionLabels) && ($groupKeterangan === '~' || trim($groupKeterangan) === '')) {
        $groupKeterangan = $groupSessionLabels[0];
      }

      if (trim($groupKeterangan) === '') {
        $groupKeterangan = '~';
      }

      $groupTotalHarga = array_sum(array_map(function ($index) use ($entryAmounts) {
        return $entryAmounts[$index] ?? 0;
      }, $groupIndices));

      $groupSessionPayload = array_map(function ($entry) {
        return [
          'start' => $entry['start'],
          'end' => $entry['end'],
          'session_start' => $entry['session_start'] ?? null,
          'label' => isset($entry['start'], $entry['end'])
            ? 'Jadwal ' . Carbon::parse($entry['start'])->format('H:i') . ' - ' . Carbon::parse($entry['end'])->format('H:i')
            : null,
        ];
      }, $groupEntries);

      $this->penyewaPeminjamanRepository->createPeminjamanWithSessions([
        'nama_peminjam' => $request->input(PeminjamanDatabaseColumn::NamaPenyewa->value),
        'nomor_induk' => $request->input(PeminjamanDatabaseColumn::NomorIndukPenyewa->value),
        'nomor_telepon' => $request->input(PeminjamanDatabaseColumn::NomorTeleponPenyewa->value),
        'id_ruangan' => $idRuangan,
        'ktp_url' => $ktpUrl,
        'ktm_url' => $ktmUrl,
        'npwp_url' => $npwpUrl,
        'ktp_public_id' => $ktpPublicId ?? null,
        'ktp_format' => $ktpFormat ?? null,
        'ktm_public_id' => $ktmPublicId ?? null,
        'ktm_format' => $ktmFormat ?? null,
        'npwp_public_id' => $npwpPublicId ?? null,
        'npwp_format' => $npwpFormat ?? null,
        'role' => $role,
        'tanggal_mulai' => $groupStart,
        'tanggal_selesai' => $groupEnd,
        'jumlah' => $jumlahPeserta,
        'total_harga' => (string) $groupTotalHarga,
        'status' => $statusMenunggu,
        'keterangan' => $groupKeterangan,
      ], $groupSessionPayload);
    }
  }
}
