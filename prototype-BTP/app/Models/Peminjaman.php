<?php

namespace App\Models;

use App\Models\Users;
use App\Models\Ruangan;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Database\UsersDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Enums\Database\PeminjamanDatabaseColumn;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory, HasUuids;
    protected $table;
    protected $primaryKey;
    protected $fillable;
    protected $dates;

    public function __construct(array $attributes = [])
    {
        $this->table = PeminjamanDatabaseColumn::Peminjaman->value;
        $this->primaryKey = PeminjamanDatabaseColumn::IdPeminjaman->value;
        $this->fillable = [
            PeminjamanDatabaseColumn::NamaPenyewa->value,
            PeminjamanDatabaseColumn::StatusPenyewa->value,
            PeminjamanDatabaseColumn::NomorIndukPenyewa->value,
            PeminjamanDatabaseColumn::NomorTeleponPenyewa->value,
            PeminjamanDatabaseColumn::TanggalMulai->value,
            PeminjamanDatabaseColumn::TanggalSelesai->value,
            PeminjamanDatabaseColumn::JumlahPeserta->value,
            PeminjamanDatabaseColumn::TotalHarga->value,
            PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value,
            PeminjamanDatabaseColumn::KeteranganPenyewaan->value,
            PeminjamanDatabaseColumn::UrlKtp->value,
            RuanganDatabaseColumn::IdRuangan->value
        ];
        $this->dates = [PeminjamanDatabaseColumn::TanggalMulai->value, PeminjamanDatabaseColumn::TanggalSelesai->value];
        parent::__construct($attributes);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, UsersDatabaseColumn::IdUsers->value, UsersDatabaseColumn::IdUsers->value);
    }

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, RuanganDatabaseColumn::IdRuangan->value, RuanganDatabaseColumn::IdRuangan->value);
    }
}
