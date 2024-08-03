<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ruangan;
use App\Models\Users;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = ['invoice', 'nama_peminjam', 'role', 'id_users', 'id_ruangan', 'nomor_induk', 'nomor_telepon', 'tanggal_mulai', 'tanggal_selesai', 'jumlah', 'harga_ppn', 'status', 'keterangan'];
    protected $dates = ['tanggal_mulai', 'tanggal_selesai'];

    public function ruangan(){
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function users(){
        return $this->hasMany(Users::class , 'id_users', 'id_users');
    }
}
