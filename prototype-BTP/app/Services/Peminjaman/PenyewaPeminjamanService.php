<?php

namespace App\Services\Peminjaman;

use Exception;
use Carbon\Carbon;
use RuntimeException;
use App\Models\Ruangan;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Http\Requests\Peminjaman\BasePeminjamanRequest;
use App\Interfaces\Repositories\Ruangan\BaseRuanganRepositoryInterface;
use App\Interfaces\Repositories\Ruangan\PenyewaRuanganRepositoryInterface;
use App\Interfaces\Repositories\Peminjaman\PenyewaPeminjamanRepositoryInterface;
use App\Services\Peminjaman\Data\PeminjamanContext;

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
    $context = $this->makeContext($request);
    $documents = $this->prepareDocuments($request, $context);
    $bookingEntries = $this->createBookingEntries($request, $context);

    $this->validateBookingEntries($request, $context, $bookingEntries);

    $bookingEntries = $this->sortBookingEntries($bookingEntries);
    $entryAmounts = $this->calculateEntryAmounts($context->totalHargaForm(), count($bookingEntries));
    $groupPayloads = $this->prepareGroupedPayloads($bookingEntries, $entryAmounts, $context);

    $this->persistBookingGroups($groupPayloads, $context, $documents);
  }

  protected function makeContext(BasePeminjamanRequest $request): PeminjamanContext
  {
    $idRuangan = $request->input(RuanganDatabaseColumn::IdRuangan->value);
    $ruangan = $this->baseRuanganRepository->getRuanganById($idRuangan);

    if (!$ruangan) {
      throw new NotFoundHttpException('Ruangan tidak ditemukan.');
    }

    return PeminjamanContext::fromRequest($request, $ruangan);
  }

  protected function prepareDocuments(BasePeminjamanRequest $request, PeminjamanContext $context): array
  {
    $documents = [
      'ktp_url' => null,
      'ktm_url' => null,
      'npwp_url' => null,
      'ktp_public_id' => null,
      'ktp_format' => null,
      'ktm_public_id' => null,
      'ktm_format' => null,
      'npwp_public_id' => null,
      'npwp_format' => null,
    ];

    if ($context->isPegawai()) {
      return $documents;
    }

    $ktpFile = $request->file(PeminjamanDatabaseColumn::UrlKtp->value);
    if (!$ktpFile instanceof UploadedFile) {
      throw new RuntimeException('Upload KTP gagal. Silakan coba lagi nanti.');
    }

    $ktpUpload = $this->uploadDocument($ktpFile, 'ktp-btp');
    if (empty($ktpUpload['url']) || empty($ktpUpload['public_id'])) {
      throw new RuntimeException('Upload KTP gagal. Silakan coba lagi nanti.');
    }
    $documents['ktp_url'] = $ktpUpload['url'];
    $documents['ktp_public_id'] = $ktpUpload['public_id'];
    $documents['ktp_format'] = $ktpUpload['format'];

    if ($context->isMahasiswa()) {
      $ktmFile = $request->file(PeminjamanDatabaseColumn::UrlKtm->value);
      $ktmUpload = $ktmFile ? $this->uploadDocument($ktmFile, 'ktm-btp') : null;
      if (!$ktmUpload || empty($ktmUpload['url']) || empty($ktmUpload['public_id'])) {
        throw new RuntimeException('Upload KTM gagal. Silakan coba lagi nanti.');
      }
      $documents['ktm_url'] = $ktmUpload['url'];
      $documents['ktm_public_id'] = $ktmUpload['public_id'];
      $documents['ktm_format'] = $ktmUpload['format'];
    }

    if ($context->isUmum() && $request->hasFile(PeminjamanDatabaseColumn::UrlNpwp->value)) {
      $npwpFile = $request->file(PeminjamanDatabaseColumn::UrlNpwp->value);
      $npwpUpload = $npwpFile ? $this->uploadDocument($npwpFile, 'npwp-btp') : null;
      if ($npwpUpload && !empty($npwpUpload['public_id'])) {
        $documents['npwp_url'] = $npwpUpload['url'];
        $documents['npwp_public_id'] = $npwpUpload['public_id'];
        $documents['npwp_format'] = $npwpUpload['format'];
      }
    }

    return $documents;
  }

  protected function createBookingEntries(BasePeminjamanRequest $request, PeminjamanContext $context): array
  {
    if ($context->isPegawai()) {
      return $this->createPegawaiEntries($request);
    }

    return $this->createNonPegawaiEntries($request, $context);
  }

  protected function createPegawaiEntries(BasePeminjamanRequest $request): array
  {
    $tanggalMulaiInput = $request->input(PeminjamanDatabaseColumn::TanggalMulai->value);
    $jamMulaiInput = $request->input(PeminjamanDatabaseColumn::JamMulai->value);
    $tanggalMulai = Carbon::parse($tanggalMulaiInput . ' ' . $jamMulaiInput)->format('Y-m-d H:i:s');
    $tanggalSelesai = $this->calculateTanggalSelesaiPegawai(
      $request->input(PeminjamanDatabaseColumn::TanggalSelesai->value),
      $request->input(PeminjamanDatabaseColumn::JamSelesai->value)
    );

    return [
      [
        'start' => $tanggalMulai,
        'end' => $tanggalSelesai,
        'session_start' => $jamMulaiInput,
      ],
    ];
  }

  protected function createNonPegawaiEntries(BasePeminjamanRequest $request, PeminjamanContext $context): array
  {
    $tanggalMulaiInput = $context->tanggalMulaiInput();

    if ($context->isCoworkingSeatHarian()) {
      return [
        [
          'start' => $tanggalMulaiInput . ' 08:00:00',
          'end' => $tanggalMulaiInput . ' 22:00:00',
          'session_start' => '08:00',
        ],
      ];
    }

    if ($context->isCoworkingSeatBulanan()) {
      $tanggalMulai = $tanggalMulaiInput . ' 08:00:00';
      $tanggalSelesai = Carbon::parse($tanggalMulaiInput)
        ->addDays(30)
        ->format('Y-m-d') . ' 22:00:00';

      return [
        [
          'start' => $tanggalMulai,
          'end' => $tanggalSelesai,
          'session_start' => '08:00',
        ],
      ];
    }

    if ($context->isPrivateOfficeBulanan()) {
      $bulan = (int) $request->input(PeminjamanDatabaseColumn::DurasiPerBulan->value);
      $bulan = $bulan > 0 ? $bulan : 1;

      $tanggalMulai = $tanggalMulaiInput . ' 08:00:00';
      $tanggalSelesai = Carbon::parse($tanggalMulaiInput)
        ->addMonths($bulan)
        ->subDay()
        ->format('Y-m-d') . ' 22:00:00';

      return [
        [
          'start' => $tanggalMulai,
          'end' => $tanggalSelesai,
          'session_start' => '08:00',
        ],
      ];
    }

    $sessions = $this->resolveSessions($request, $context);
    $entries = [];

    foreach ($sessions as $sessionStart) {
      $start = Carbon::parse($tanggalMulaiInput . ' ' . $sessionStart)->format('Y-m-d H:i:s');
      $end = $this->calculateTanggalSelesaiMahasiswa($tanggalMulaiInput, $sessionStart);

      $entries[] = [
        'start' => $start,
        'end' => $end,
        'session_start' => $sessionStart,
      ];
    }

    return $entries;
  }

  protected function resolveSessions(BasePeminjamanRequest $request, PeminjamanContext $context): array
  {
    $sessions = $request->input('jam_mulai_sessions', []);
    if (!is_array($sessions)) {
      $sessions = [$sessions];
    }

    $sessions = array_values(array_unique(array_filter($sessions)));
    if (empty($sessions)) {
      $sessions = [$request->input(PeminjamanDatabaseColumn::JamMulai->value)];
    }
    sort($sessions);

    if ($context->jumlahSesi() && count($sessions) !== $context->jumlahSesi()) {
      throw new RuntimeException('Jumlah sesi yang dipilih tidak sesuai.');
    }

    return $sessions;
  }

  protected function validateBookingEntries(
    BasePeminjamanRequest $request,
    PeminjamanContext $context,
    array $bookingEntries
  ): void {
    if (empty($bookingEntries)) {
      throw new RuntimeException('Tidak ada sesi peminjaman yang dipilih.');
    }

    if ($context->shouldCheckOverlap()) {
      foreach ($bookingEntries as $entry) {
        if ($this->penyewaPeminjamanRepository->existsOverlapPeminjaman(
          $context->idRuangan(),
          $entry['start'],
          $entry['end']
        )) {
          $startTime = Carbon::parse($entry['start'])->format('H:i');
          throw new RuntimeException('Ruangan sudah dibooking pada sesi ' . $startTime . '. Silakan pilih waktu lain.');
        }
      }
    }

    if ($context->requiresSeatValidation()) {
      $this->ensureSeatAvailability($request, $context);
    }
  }

  protected function ensureSeatAvailability(BasePeminjamanRequest $request, PeminjamanContext $context): void
  {
    $ruanganGroupIds = [$context->idRuangan()];
    if ($context->groupId()) {
      $ruanganGroupIds = $this->penyewaRuanganRepository->getRuanganByGroupId($context->groupId())
        ->pluck(RuanganDatabaseColumn::IdRuangan->value)
        ->toArray();
    }

    $sisaSeatData = $this->penyewaPeminjamanRepository->getCoworkingSeatAvailability(
      $ruanganGroupIds,
      $request->input(PeminjamanDatabaseColumn::TanggalMulai->value)
    );
    $sisaSeat = $sisaSeatData['sisa_seat'] ?? 0;

    if ($context->jumlahPeserta() > $sisaSeat) {
      throw new RuntimeException('Jumlah peserta melebihi sisa seat. Tersisa hanya ' . $sisaSeat . ' kursi.');
    }
  }

  protected function sortBookingEntries(array $bookingEntries): array
  {
    usort($bookingEntries, function ($a, $b) {
      return strcmp($a['start'], $b['start']);
    });

    return $bookingEntries;
  }

  protected function calculateEntryAmounts(float $totalHargaForm, int $entryCount): array
  {
    $total = round(max(0, $totalHargaForm));
    $entryAmounts = [];
    $remainingTotal = $total;

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

    return $entryAmounts;
  }

  protected function prepareGroupedPayloads(array $bookingEntries, array $entryAmounts, PeminjamanContext $context): array
  {
    $indexedEntries = [];
    foreach ($bookingEntries as $index => $entry) {
      $indexedEntries[] = [
        'entry' => $entry,
        'index' => $index,
      ];
    }

    $halfdayOrder = $this->halfdayOrder();
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

    $payloads = [];
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

      $groupKeterangan = $this->buildGroupKeterangan($context->keteranganBase(), $groupSessionLabels);

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

      $payloads[] = [
        'tanggal_mulai' => $groupStart,
        'tanggal_selesai' => $groupEnd,
        'keterangan' => $groupKeterangan,
        'total_harga' => (string) $groupTotalHarga,
        'sessions' => $groupSessionPayload,
      ];
    }

    return $payloads;
  }

  protected function halfdayOrder(): array
  {
    return [
      '08:00' => 0,
      '13:00' => 1,
      '18:00' => 2,
    ];
  }

  protected function buildGroupKeterangan(string $baseKeterangan, array $sessionLabels): string
  {
    $groupKeterangan = $baseKeterangan;
    $shouldAppendGroupSlots = count($sessionLabels) > 1;

    if ($shouldAppendGroupSlots) {
      if ($groupKeterangan === '~' || trim($groupKeterangan) === '') {
        $groupKeterangan = implode(' | ', $sessionLabels);
      } else {
        $groupKeterangan .= ' | ' . implode(' | ', $sessionLabels);
      }
    } elseif (!empty($sessionLabels) && ($groupKeterangan === '~' || trim($groupKeterangan) === '')) {
      $groupKeterangan = $sessionLabels[0];
    }

    if (trim($groupKeterangan) === '') {
      $groupKeterangan = '~';
    }

    return $groupKeterangan;
  }

  protected function persistBookingGroups(array $groupPayloads, PeminjamanContext $context, array $documents): void
  {
    foreach ($groupPayloads as $payload) {
      $data = array_merge($documents, [
        'nama_peminjam' => $context->namaPeminjam(),
        'nomor_induk' => $context->nomorInduk(),
        'nomor_telepon' => $context->nomorTelepon(),
        'id_ruangan' => $context->idRuangan(),
        'role' => $context->role(),
        'jumlah' => $context->jumlahPeserta(),
        'status' => $context->statusMenunggu(),
        'tanggal_mulai' => $payload['tanggal_mulai'],
        'tanggal_selesai' => $payload['tanggal_selesai'],
        'total_harga' => $payload['total_harga'],
        'keterangan' => $payload['keterangan'],
      ]);

      $this->penyewaPeminjamanRepository->createPeminjamanWithSessions($data, $payload['sessions']);
    }
  }
}
