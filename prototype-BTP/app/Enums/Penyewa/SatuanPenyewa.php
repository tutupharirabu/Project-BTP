<?php

namespace App\Enums\Penyewa;

enum SatuanPenyewa: string
{
  case Halfday = 'Halfday / 4 Jam';
  case SeatPerHari = 'Seat / Hari';
  case SeatPerBulan = 'Seat / Bulan';
}