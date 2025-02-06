<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Ruangan;

class Gambar extends Model
{
    use HasFactory;
    protected $table = 'gambar';
    protected $primaryKey = 'id_gambar';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_ruangan', 'url'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function ruangan(){
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }
}
