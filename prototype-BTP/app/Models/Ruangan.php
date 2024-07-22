<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Meminjam;
// use App\Models\MeminjamRuangan;
use App\Models\Mengelola;
use App\Models\Gambar;
use App\Models\Users;

class Ruangan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_ruangan';
    protected $table = 'ruangan';
    protected $fillable = ['nama_ruangan', 'kapasitas_minimal', 'kapasitas_maksimal', 'satuan', 'lokasi', 'harga_ruangan', 'tersedia', 'status', 'id_users'];

    public function mengelola() {
        return $this->belongsTo(Mengelola::class, 'id_pengelola', 'id_pengelola');
    }

    public function gambar(){
        return $this->hasMany(Gambar::class, 'id_ruangan', 'id_ruangan');
    }

    public function users(){
        return $this->hasMany(Users::class , 'id_users', 'id_users');
    }
}
