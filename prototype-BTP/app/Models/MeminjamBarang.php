<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penyewa;
use App\Models\Barang;

class MeminjamBarang extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_meminjamBarang';
    protected $table = 'meminjam_barang';
    protected $fillable = ['tanggal_peminjaman', 'tanggal_selesai', 'id_penyewa', 'id_barang', 'jumlah_barang'];

    public function penyewa() {
        return $this->belongsTo(Penyewa::class, 'id_penyewa', 'id_penyewa');
    }

    public function barang(){
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    // protected $attributes = [
    //     'jumlah_barang' => 1, // Nilai default untuk jumlah_barang
    // ];
}
