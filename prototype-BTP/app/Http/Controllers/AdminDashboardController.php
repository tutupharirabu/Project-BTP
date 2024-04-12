<?php

namespace App\Http\Controllers;

use App\Models\RoomLogs;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index() {
       $room_logs = RoomLogs::all();

        return view('dashboardAdmin', [
            'title' => 'dashboardAdmin',
            'active' => 'dashboardAdmin'
        ], compact('room_logs'));
    }
}
