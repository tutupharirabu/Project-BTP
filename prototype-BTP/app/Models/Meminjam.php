<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penyewa;
use App\Models\Barang;
use App\Models\Ruangan;


class Meminjam extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_peminjaman';
    protected $table = 'meminjam';
    protected $fillable = ['tanggal_peminjaman', 'tanggal_selesai', 'jumlah_pengguna', 'id_penyewa', 'id_barang', 'id_ruangan'];

    public function penyewa() {
        return $this->belongsTo(Penyewa::class, 'id_penyewa', 'id_penyewa');
    }

    public function barang(){
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function ruangan(){
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }
}
