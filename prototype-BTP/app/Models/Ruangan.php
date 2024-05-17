<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meminjam;
use App\Models\MeminjamRuangan;
use App\Models\Mengelola;
use App\Models\Gambar;

class Ruangan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_ruangan';
    protected $table = 'ruangan';
    protected $fillable = ['nama_ruangan', 'kapasitas_ruangan', 'foto_ruangan', 'lokasi', 'harga_ruangan', 'tersedia', 'status'];

    public function meminjam() {
        return $this->belongsTo(Meminjam::class, 'id_meminjam', 'id_meminjam');
    }

    public function meminjam_ruangan() {
        return $this->belongsTo(MeminjamRuangan::class, 'id_meminjamRuangan', 'id_meminjamRuangan');
    }

    public function mengelola() {
        return $this->belongsTo(Mengelola::class, 'id_pengelola', 'id_pengelola');
    }

    public function gambar(){
        return $this->hasMany(Gambar::class, 'id_ruangan', 'id_ruangan');
    }
}
