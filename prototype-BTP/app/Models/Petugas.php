<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_petugas';
    protected $table = 'petugas';
    protected $fillable = ['id_petugas', 'nama_lengkap', 'jenis_kelamin', 'alamat', 'nomor_telepon', 'email', 'password'];
}
