<?php

namespace App\Models;

use App\Models\Ruangan;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Hash;
use App\Enums\Database\UsersDatabaseColumn;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use HasFactory, HasUuids;

    protected $table = UsersDatabaseColumn::Users->value;
    protected $primaryKey = UsersDatabaseColumn::IdUsers->value;
    protected $fillable = [UsersDatabaseColumn::Username->value, UsersDatabaseColumn::Password->value, UsersDatabaseColumn::Email->value, UsersDatabaseColumn::Role->value, UsersDatabaseColumn::NamaLengkap->value];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => Hash::make($value)
        );
    }

    public function ruangans(): HasMany
    {
        return $this->hasMany(Ruangan::class, UsersDatabaseColumn::IdUsers->value, UsersDatabaseColumn::IdUsers->value);
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, UsersDatabaseColumn::IdUsers->value, UsersDatabaseColumn::IdUsers->value);
    }

}
