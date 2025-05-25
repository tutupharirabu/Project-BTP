<?php

namespace App\Enums;

enum StatusPeminjaman: string
{
    case Menunggu = 'Menunggu';
    case Disetujui = 'Disetujui';
    case Ditolak = 'Ditolak';
    case Selesai = 'Selesai';
}