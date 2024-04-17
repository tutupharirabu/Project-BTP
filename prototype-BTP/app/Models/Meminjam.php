<?php

namespace App\Models;

use App\Models\Barang;
use App\Models\Penyewa;
use App\Models\Ruangan;
use App\Models\MeminjamBarang;
use App\Models\MeminjamRuangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Meminjam extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_peminjaman';
    protected $table = 'meminjam';
    protected $fillable = ['tanggal_peminjaman', 'tanggal_selesai', 'jumlah_pengguna', 'jumlah_barang', 'id_penyewa', 'id_barang', 'id_ruangan'];

    public function penyewa() {
        return $this->belongsTo(Penyewa::class, 'id_penyewa', 'id_penyewa');
    }

    public function barang(){
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function ruangan(){
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

    public function meminjam_barang() {
        return $this->belongsTo(MeminjamBarang::class, 'id_meminjamBarang', 'id_meminjamBarang');
    }

    public function meminjam_ruangan() {
        return $this->belongsTo(MeminjamRuangan::class, 'id_meminjamRuangan', 'id_meminjamRuangan');
    }
}
