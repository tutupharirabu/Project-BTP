<?php

namespace App\Models;

use App\Models\Meminjam;
use App\Models\Mengelola;
use App\Models\MeminjamBarang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_barang';
    protected $table = 'barang';
    protected $fillable = ['nama_barang', 'jumlah_barang', 'foto_barang'];

    public function meminjam() {
        return $this->belongsTo(Meminjam::class, 'id_meminjam', 'id_meminjam');
    }

    public function meminjam_barang() {
        return $this->belongsTo(MeminjamBarang::class, 'id_meminjamBarang', 'id_meminjamBarang');
    }

    public function mengelola() {
        return $this->belongsTo(Mengelola::class, 'id_pengelola', 'id_pengelola');
    }
}
