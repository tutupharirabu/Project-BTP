<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ruangan;
use App\Models\Barang;
use App\Models\Users;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = ['nama_peminjam', 'role', 'nomor_induk', 'nomor_telepon', 'id_users','id_ruangan', 'tanggal_mulai', 'tanggal_selesai', 'jumlah', 'status', 'keterangan'];
    protected $dates = ['tanggal_mulai', 'tanggal_selesai'];

    public function ruangan(){
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function barang(){
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function users(){
        return $this->hasMany(Users::class , 'id_users', 'id_users');
    }
}
