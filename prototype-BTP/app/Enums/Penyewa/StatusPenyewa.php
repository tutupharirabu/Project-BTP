<?php 

namespace App\Enums\Penyewa;

enum StatusPenyewa: string
{
  case Pegawai = 'Pegawai';
  case Mahasiswa = 'Mahasiswa';
  case Umum = 'Umum';
}