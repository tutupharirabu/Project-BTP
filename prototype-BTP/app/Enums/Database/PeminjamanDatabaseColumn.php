<?php

namespace App\Enums\Database;

enum PeminjamanDatabaseColumn: string
{
    case Peminjaman = 'peminjaman';
    case IdPeminjaman = 'id_peminjaman';
    case NamaPenyewa = 'nama_peminjam';
    case StatusPenyewa = 'role';
    case NomorIndukPenyewa = 'nomor_induk';
    case NomorTeleponPenyewa = 'nomor_telepon';
    case UrlKtp = 'ktp_url';
    case TanggalMulai = 'tanggal_mulai';
    case JamMulai = 'jam_mulai';
    case TanggalSelesai = 'tanggal_selesai';
    case JamSelesai = 'jam_selesai';
    case DurasiPerBulan = 'durasi_bulan';
    case JumlahPeserta = 'jumlah';
    case TotalHarga = 'total_harga';
    case StatusPeminjamanPenyewa = 'status';
    case KeteranganPenyewaan = 'keterangan';
    case CreatedAt = 'created_at';
    case UpdatedAt = 'updated_at';
}