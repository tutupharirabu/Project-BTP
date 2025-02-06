<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Mengelola;
use App\Models\Gambar;
use App\Models\Users;

class Ruangan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_ruangan';
    protected $table = 'ruangan';
    protected $fillable = ['nama_ruangan', 'ukuran', 'kapasitas_minimal', 'kapasitas_maksimal', 'satuan', 'lokasi', 'harga_ruangan', 'tersedia', 'status', 'keterangan', 'id_users'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

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
