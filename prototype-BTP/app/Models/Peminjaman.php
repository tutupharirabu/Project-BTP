<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ruangan;
use App\Models\Barang;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = ['id_users', 'id_ruangan', 'tanggal_mulai', 'tanggal_mulai', 'tanggal_selesai', 'jumlah', 'status'];

    public function ruangan(){
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

    public function barang(){
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
