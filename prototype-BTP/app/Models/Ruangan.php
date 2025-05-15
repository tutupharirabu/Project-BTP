<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gambar;
use App\Models\Users;

class Ruangan extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id_ruangan';
    protected $table = 'ruangan';
    protected $fillable = [
        'nama_ruangan', 
        'kapasitas_maksimal', 
        'kapasitas_minimal',  
        'satuan', 
        'lokasi', 
        'harga_ruangan',
        'status', 
        'keterangan', 
        'id_users'
    ];

    public function gambar(){
        return $this->hasMany(Gambar::class, 'id_ruangan', 'id_ruangan');
    }

    public function users(){
        return $this->hasMany(Users::class , 'id_users', 'id_users'); // Ini salah cara relasinya harusnya belongsTo
    } 
}
