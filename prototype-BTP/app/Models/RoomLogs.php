<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomLogs extends Model
{
    use HasFactory;

    protected $table = 'room_logs';
    protected $primaryKey = 'id';

    protected $fillable = ['room_id', 'keperluan', 'jumlahPeserta&Panitia', 'borrow_date_start', 'borrow_date_end', 'jam_mulai', 'jam_berakhir', 'penanggungjawab', 'img'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function room()
    {
        return $this->belongsTo('App\Models\Room');
    }
}
