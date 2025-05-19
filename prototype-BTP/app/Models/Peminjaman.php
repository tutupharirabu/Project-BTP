<?php

namespace App\Models;

use App\Models\Users;
use App\Models\Ruangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = ['nama_peminjam', 'role', 'nomor_induk', 'nomor_telepon', 'tanggal_mulai', 'tanggal_selesai', 'jumlah', 'total_harga', 'status', 'keterangan', 'ktp_url', 'id_ruangan'];
    protected $dates = ['tanggal_mulai', 'tanggal_selesai'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'id_users', 'id_users');
    }
    
    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }
}
