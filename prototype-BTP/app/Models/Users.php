<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class Users extends Authenticatable
{
    use HasFactory, HasUuids;

    protected $table = 'users';
    protected $primaryKey = 'id_users';
    protected $fillable = ['username', 'email', 'role', 'nama_lengkap', 'password'];

}
