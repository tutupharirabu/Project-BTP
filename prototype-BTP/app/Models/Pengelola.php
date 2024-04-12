<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Petugas;
use App\Models\Ruangan;
use App\Models\Barang;

class Pengelola extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pengelola';
    protected $table = 'pengelola';
    protected $fillable = ['id_petugas', 'id_ruangan', 'id_barang'];

    public function petugas(){
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function ruangan(){
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

    public function barang(){
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
