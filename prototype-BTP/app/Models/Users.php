<?php

namespace App\Models;

use App\Models\Ruangan;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use HasFactory, HasUuids;

    protected $table = 'users';
    protected $primaryKey = 'id_users';
    protected $fillable = ['username', 'password', 'email', 'role', 'nama_lengkap'];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => Hash::make($value)
        );
    }

    public function ruangans(): HasMany
    {
        return $this->hasMany(Ruangan::class, 'id_users', 'id_users');
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'id_users', 'id_users');
    }

}
