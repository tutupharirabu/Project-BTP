<?php

namespace App\Models;

use App\Models\Users;
use App\Models\Gambar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'id_users', 'id_users'); // Ini salah cara relasinya harusnya belongsTo
    }

    public function gambars(): HasMany
    {
        return $this->hasMany(Gambar::class, 'id_ruangan', 'id_ruangan');
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'id_ruangan', 'id_ruangan');
    }
}
