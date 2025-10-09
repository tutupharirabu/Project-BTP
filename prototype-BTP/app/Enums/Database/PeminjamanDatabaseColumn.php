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
    case UrlKtm = 'ktm_url';
    case UrlNpwp = 'npwp_url';
    case KtpPublicId = 'ktp_public_id';
    case KtpFormat = 'ktp_format';
    case KtmPublicId = 'ktm_public_id';
    case KtmFormat = 'ktm_format';
    case NpwpPublicId = 'npwp_public_id';
    case NpwpFormat = 'npwp_format';
    case TanggalMulai = 'tanggal_mulai';
    case JamMulai = 'jam_mulai';
    case TanggalSelesai = 'tanggal_selesai';
    case JamSelesai = 'jam_selesai';
    case DurasiPerBulan = 'durasi_bulan';
    case JumlahPeserta = 'jumlah';
    case TotalHarga = 'total_harga';
    case StatusPeminjamanPenyewa = 'status';
    case InvoiceNumber = 'invoice_number';
    case KeteranganPenyewaan = 'keterangan';
    case CreatedAt = 'created_at';
    case UpdatedAt = 'updated_at';
}
