<?php

namespace App\Models;

use App\Enums\Database\RuanganDatabaseColumn;
use App\Models\Ruangan;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Database\GambarDatabaseColumn;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gambar extends Model
{
    use HasFactory, HasUuids;
    protected $table;
    protected $primaryKey;
    protected $fillable;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = GambarDatabaseColumn::Gambar->value;
        $this->primaryKey = GambarDatabaseColumn::IdGambar->value;
        $this->fillable = [RuanganDatabaseColumn::IdRuangan->value, GambarDatabaseColumn::UrlGambar->value];
    }

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, RuanganDatabaseColumn::IdRuangan->value, RuanganDatabaseColumn::IdRuangan->value);
    }
}
