<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Penyewa extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;
    protected $primaryKey = 'id_penyewa';
    protected $table = 'penyewa';
    protected $fillable = ['nama_lengkap', 'jenis_kelamin', 'instansi', 'status', 'alamat', 'email', 'password'];
}
