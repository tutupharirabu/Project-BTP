<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory, HasUuids;
protected $table = 'otp';
protected $primaryKey = 'otp_id';

    protected $fillable = [
        'id_users',
        'otp_code',
        'expired_at'
    ];

    public $timestamps = true;
}
