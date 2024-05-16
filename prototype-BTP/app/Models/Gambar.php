<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ruangan;

class Gambar extends Model
{
    use HasFactory;
    protected $table = 'gambar';
    protected $primaryKey = 'id_gambar';
    protected $fillable = ['id_ruangan', 'url'];

    public function ruangan(){
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }
}
