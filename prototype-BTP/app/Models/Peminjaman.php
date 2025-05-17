<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Ruangan;
use App\Models\Users;

class Peminjaman extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = ['nama_peminjam', 'role', 'id_users', 'id_ruangan', 'nomor_induk', 'nomor_telepon', 'tanggal_mulai', 'tanggal_selesai', 'jumlah', 'total_harga', 'status', 'keterangan', 'ktp_url'];
    protected $dates = ['tanggal_mulai', 'tanggal_selesai'];

    public function ruangan(){
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function users(){
        return $this->hasMany(Users::class , 'id_users', 'id_users');
    }
}
