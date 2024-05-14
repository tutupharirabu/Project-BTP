<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'id_users';
    protected $fillable = ['username','email', 'role', 'nama_lengkap','password'];
}
