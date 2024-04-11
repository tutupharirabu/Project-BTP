<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_ruangan';
    protected $table = 'ruangan';
    protected $fillable = ['nama_ruangan', 'kapasitas_ruangan', 'foto_ruangan', 'lokasi'];
}
