<?php

namespace App\Repositories\Peminjaman;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\Ruangan;
use App\Models\Peminjaman;
use App\Interfaces\Repositories\Peminjaman\PenyewaPeminjamanRepositoryInterface;

class PenyewaPeminjamanRepository implements PenyewaPeminjamanRepositoryInterface
{
  public function getAllPeminjaman()
  {
    return Peminjaman::all();
  }

  public function createPeminjaman(array $data): Peminjaman
  {
    return Peminjaman::create($data);
  }

  public function existsOverlapPeminjaman(string $id_ruangan, string $tanggal_mulai, string $tanggal_selesai): bool
  {
    return Peminjaman::where('id_ruangan', $id_ruangan)
      ->where('status', 'Disetujui')
      ->where(function ($query) use ($tanggal_mulai, $tanggal_selesai) {
        $query->where('tanggal_mulai', '<', $tanggal_selesai)
          ->where('tanggal_selesai', '>', $tanggal_mulai);
      })
      ->exists();
  }

  public function getUnavailableJam(string $idRuangan, string $tanggal): array
  {
    $bookings = Peminjaman::where('id_ruangan', $idRuangan)
      ->where('status', 'Disetujui')
      ->whereDate('tanggal_mulai', $tanggal)
      ->get(['tanggal_mulai', 'tanggal_selesai']);

    $allJam = [];
    for ($hour = 8; $hour <= 22; $hour++) {
      $allJam[] = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
      if ($hour != 22) { // Biar tidak nambah 18:30 kalau jam akhir 18:00
        $allJam[] = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':30';
      }
    }

    $unavailableJam = [];
    foreach ($allJam as $jam) {
      $current = Carbon::createFromFormat('Y-m-d H:i', "$tanggal $jam");
      foreach ($bookings as $booking) {
        $mulai = Carbon::parse($booking->tanggal_mulai);
        $selesai = Carbon::parse($booking->tanggal_selesai);
        if ($current->greaterThanOrEqualTo($mulai) && $current->lessThanOrEqualTo($selesai)) {
          $unavailableJam[] = $jam;
          break;
        }
      }
    }
    return $unavailableJam;
  }

  public function getGroupRuanganIdsByRuanganId(string $idRuangan): array
  {
    $ruangan = Ruangan::find($idRuangan);
    if ($ruangan && $ruangan->group_id_ruangan) {
      return Ruangan::where('group_id_ruangan', $ruangan->group_id_ruangan)
        ->pluck('id_ruangan')
        ->toArray();
    } else {
      return [$idRuangan];
    }
  }

  public function getUnavailableTanggal(string $idRuangan): array
  {
    // Ambil semua booking yang disetujui
    $bookings = Peminjaman::where('id_ruangan', $idRuangan)
      ->where('status', 'Disetujui')
      ->get(['tanggal_mulai', 'tanggal_selesai']);

    // Kumpulkan semua tanggal yang punya booking di range booking
    $tanggalTerbooking = [];
    foreach ($bookings as $booking) {
      $start = Carbon::parse($booking->tanggal_mulai)->toDateString();
      $end = Carbon::parse($booking->tanggal_selesai)->toDateString();

      $periode = new DatePeriod(
        new DateTime($start),
        new DateInterval('P1D'),
        (new DateTime($end))->modify('+1 day')
      );
      foreach ($periode as $date) {
        $tanggalTerbooking[] = $date->format('Y-m-d');
      }
    }
    $tanggalTerbooking = array_unique($tanggalTerbooking);

    // Untuk tiap tanggal, cek apakah SEMUA slot jam sudah penuh
    $allJam = [];
    for ($hour = 8; $hour <= 22; $hour++) {
      $allJam[] = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
      if ($hour != 22) {
        $allJam[] = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':30';
      }
    }

    $unavailableDates = [];
    foreach ($tanggalTerbooking as $tanggal) {
      $slotUsed = [];
      foreach ($allJam as $jam) {
        $current = Carbon::createFromFormat('Y-m-d H:i', "$tanggal $jam");
        foreach ($bookings as $booking) {
          $mulai = Carbon::parse($booking->tanggal_mulai);
          $selesai = Carbon::parse($booking->tanggal_selesai);
          if ($current->greaterThanOrEqualTo($mulai) && $current->lessThanOrEqualTo($selesai)) {
            $slotUsed[] = $jam;
            break;
          }
        }
      }
      // Jika semua slot jam di hari itu sudah occupied
      if (count(array_unique($slotUsed)) === count($allJam)) {
        $unavailableDates[] = $tanggal;
      }
    }
    return array_values(array_unique($unavailableDates));
  }

  public function getAvailableJamMulaiHalfday(string $id_ruangan, string $tanggal): array
  {
    // Ambil semua booking pada tanggal tersebut
    $bookings = Peminjaman::where('id_ruangan', $id_ruangan)
      ->where('status', 'Disetujui')
      ->whereDate('tanggal_mulai', $tanggal)
      ->get(['tanggal_mulai', 'tanggal_selesai']);

    // Generate semua kemungkinan jam_mulai (misal: 08:00-18:00 setiap 30 menit)
    $jamMulaiList = [];
    $opening = Carbon::parse("$tanggal 08:00");
    $closing = Carbon::parse("$tanggal 18:00"); // jam terakhir untuk 4 jam (22:00 - 4 jam)

    for ($time = $opening->copy(); $time->lte($closing); $time->addMinutes(30)) {
      $slotStart = $time->copy();
      $slotEnd = $slotStart->copy()->addHours(4);

      $isAvailable = true;
      foreach ($bookings as $b) {
        $bookStart = Carbon::parse($b->tanggal_mulai);
        $bookEnd = Carbon::parse($b->tanggal_selesai);
        // Overlap check: slotStart < bookEnd && slotEnd > bookStart
        if ($slotStart->lt($bookEnd) && $slotEnd->gt($bookStart)) {
          $isAvailable = false;
          break;
        }
      }
      if ($isAvailable && $slotEnd->format('Y-m-d') === $tanggal) {
        $jamMulaiList[] = $slotStart->format('H:i');
      }
    }
    return $jamMulaiList;
  }

  public function getCoworkingFullyBookedDates($id_ruangan): array
  {
    // Support array (group) or single string
    $idRuanganArray = is_array($id_ruangan) ? $id_ruangan : [$id_ruangan];

    // Ambil kapasitas minimal di group, agar lebih aman (jika seat beda-beda, dipakai yang paling kecil)
    $kapasitas = Ruangan::whereIn('id_ruangan', $idRuanganArray)->min('kapasitas_maksimal');

    // Validasi: Hanya proses jika SEMUA ruangan group seat/hari & ada embel-embel coworking
    // Ambil dulu satu ruangan acuan
    $sampleRuangan = Ruangan::whereIn('id_ruangan', $idRuanganArray)->first();
    if (
      !$sampleRuangan ||
      strtolower($sampleRuangan->satuan) !== 'seat / hari' ||
      stripos($sampleRuangan->nama_ruangan, 'coworking') === false
    ) {
      return [];
    }

    // Booking di seluruh ruangan group
    $bookings = Peminjaman::whereIn('id_ruangan', $idRuanganArray)
      ->where('status', 'Disetujui')
      ->whereNotNull('tanggal_mulai')
      ->get();

    $dateSeatCount = [];
    foreach ($bookings as $b) {
      $tanggal = Carbon::parse($b->tanggal_mulai)->toDateString();
      $seat = $b->jumlah ?? 1; // Default 1 jika tidak ada field
      $dateSeatCount[$tanggal] = ($dateSeatCount[$tanggal] ?? 0) + $seat;
    }
    $fullyBookedDates = [];
    foreach ($dateSeatCount as $date => $count) {
      if ($count >= $kapasitas) {
        $fullyBookedDates[] = $date;
      }
    }
    return $fullyBookedDates;
  }

  public function getCoworkingBlockedStartDatesForBulan($id_ruangan): array
  {
    // $id_ruangan bisa string (single) atau array (group)
    $idRuanganArray = is_array($id_ruangan) ? $id_ruangan : [$id_ruangan];
    $kapasitas = Ruangan::whereIn('id_ruangan', $idRuanganArray)->min('kapasitas_maksimal');
    $today = Carbon::today();
    $rangeToCheck = 60; // cek 2 bulan ke depan
    $blockedDates = [];

    for ($i = 0; $i < $rangeToCheck; $i++) {
      $start = $today->copy()->addDays($i);
      $allSeatAvailable = true;
      // Cek 30 hari ke depan dari tanggal mulai ini
      for ($j = 0; $j < 30; $j++) {
        $checkDate = $start->copy()->addDays($j)->toDateString();
        $seatUsed = Peminjaman::whereIn('id_ruangan', $idRuanganArray)
          ->where('status', 'Disetujui')
          ->whereDate('tanggal_mulai', '<=', $checkDate)
          ->whereDate('tanggal_selesai', '>=', $checkDate)
          ->sum('jumlah');
        if ($seatUsed >= $kapasitas) {
          $allSeatAvailable = false;
          break;
        }
      }
      if (!$allSeatAvailable) {
        $blockedDates[] = $start->toDateString();
      }
    }
    return $blockedDates;
  }

  public function getCoworkingSeatAvailability($id_ruangan, string $tanggal): array
  {
    // Dukung input array ataupun single string (biar backward compatible)
    $idRuanganArray = is_array($id_ruangan) ? $id_ruangan : [$id_ruangan];

    // Ambil kapasitas terkecil (safety)
    $kapasitas = Ruangan::whereIn('id_ruangan', $idRuanganArray)->min('kapasitas_maksimal');

    // Jumlah seluruh booking di semua ruangan pada tanggal tsb
    $booked = Peminjaman::whereIn('id_ruangan', $idRuanganArray)
      ->where('status', 'Disetujui')
      ->whereDate('tanggal_mulai', $tanggal)
      ->sum('jumlah');

    return [
      'sisa_seat' => max(0, $kapasitas - $booked),
      'kapasitas' => $kapasitas,
      'booked' => $booked,
    ];
  }

  public function getPrivateOfficeBlockedDates(string $idRuangan): array
  {
    // Ambil semua booking disetujui ruangan ini
    $bookings = Peminjaman::where('id_ruangan', $idRuangan)
      ->where('status', 'Disetujui')
      ->get(['tanggal_mulai', 'tanggal_selesai']);
    $blocked = [];
    foreach ($bookings as $b) {
      $period = new DatePeriod(
        new DateTime($b->tanggal_mulai),
        new DateInterval('P1D'),
        (new DateTime($b->tanggal_selesai))->modify('+1 day')
      );
      foreach ($period as $dt) {
        $blocked[] = $dt->format('Y-m-d');
      }
    }
    return array_values(array_unique($blocked));
  }
}