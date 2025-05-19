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
        'kapasitas_minimal',
        'kapasitas_maksimal',
        'satuan',
        'lokasi',
        'harga_ruangan',
        'status',
        'keterangan',
        'id_users'
    ];
    public function users()
    {
        return $this->hasMany(Users::class, 'id_users', 'id_users'); // Ini salah cara relasinya harusnya belongsTo
    }

    public function gambars()
    {
        return $this->hasMany(Gambar::class, 'id_ruangan', 'id_ruangan');
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_ruangan', 'id_ruangan');
    }
}
