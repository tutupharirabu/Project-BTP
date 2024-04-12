<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Admin extends Model implements Authenticatable
{
    use HasFactory;
    use AuthenticatableTrait;

    protected $primaryKey = 'id_admin';
    protected $table = 'admin';
    protected $fillable = ['nama_lengkap', 'jenis_kelamin', 'nomor_telepon', 'alamat', 'email', 'password'];
}
