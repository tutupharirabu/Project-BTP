<?php

namespace App\Enums\Database;

enum RuanganDatabaseColumn: string
{
  case Ruangan = 'ruangan';
  case GroupIdRuangan = 'group_id_ruangan';
  case IdRuangan = 'id_ruangan';
  case NamaRuangan = 'nama_ruangan';
  case KapasitasMaksimal = 'kapasitas_maksimal';
  case KapasitasMinimal = 'kapasitas_minimal';
  case SatuanPenyewaanRuangan = 'satuan';
  case LokasiRuangan = 'lokasi';
  case HargaRuangan = 'harga_ruangan';
  case KeteranganRuangan = 'keterangan';
  case StatusRuangan = 'status';
  case CreatedAt = 'created_at';
}