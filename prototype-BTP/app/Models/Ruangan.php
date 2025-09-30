<?php

namespace App\Models;

use App\Models\Users;
use App\Models\Gambar;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Database\UsersDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ruangan extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = RuanganDatabaseColumn::IdRuangan->value;
    protected $table = RuanganDatabaseColumn::Ruangan->value;
    protected $fillable = [
            RuanganDatabaseColumn::GroupIdRuangan->value,
            RuanganDatabaseColumn::NamaRuangan->value,
            RuanganDatabaseColumn::KapasitasMinimal->value,
            RuanganDatabaseColumn::KapasitasMaksimal->value,
            RuanganDatabaseColumn::SatuanPenyewaanRuangan->value,
            RuanganDatabaseColumn::LokasiRuangan->value,
            RuanganDatabaseColumn::HargaRuangan->value,
            RuanganDatabaseColumn::StatusRuangan->value,
            RuanganDatabaseColumn::KeteranganRuangan->value,
            UsersDatabaseColumn::IdUsers->value
        ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, UsersDatabaseColumn::IdUsers->value, UsersDatabaseColumn::IdUsers->value); // Ini salah cara relasinya harusnya belongsTo
    }

    public function gambars(): HasMany
    {
        return $this->hasMany(Gambar::class, RuanganDatabaseColumn::IdRuangan->value, RuanganDatabaseColumn::IdRuangan->value);
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, RuanganDatabaseColumn::IdRuangan->value, RuanganDatabaseColumn::IdRuangan->value);
    }
}
