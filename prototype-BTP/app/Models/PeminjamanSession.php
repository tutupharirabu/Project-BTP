<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\Database\PeminjamanDatabaseColumn;

class PeminjamanSession extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'peminjaman_sessions';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'peminjaman_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'session_label',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(
            Peminjaman::class,
            'peminjaman_id',
            PeminjamanDatabaseColumn::IdPeminjaman->value
        );
    }
}
