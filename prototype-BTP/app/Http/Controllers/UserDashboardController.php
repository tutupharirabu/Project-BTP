<?php

namespace App\Http\Controllers;

use App\Models\RoomLogs;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index() {
        return view('dashboardUser', [
            'title' => 'dashboard',
            'active' => 'dashboard'
        ]);
    }

    public function store(Request $request) {

        $ruang = $request->input('kategoriRuangan');
        $filename = '';

        if ($request->hasFile('img')) {
            $filename = $request->getSchemeAndHttpHost() . '/assets/img/' . time() . '.' . $request->img->extension();

            $request->img->move(public_path('/assets/img/'), $filename);
        }

        $room = new RoomLogs;
        $room->user_id = 1;
        $room->room_id = $ruang;
        $room->keperluan = $request->keperluan;
        $room->jumlahPesertaPanitia = $request->jumlahPesertaPanitia;
        $room->borrow_date_start = $request->borrow_date_start;
        $room->borrow_date_end = $request->borrow_date_end;
        $room->jam_mulai = $request->jam_mulai;
        $room->jam_berakhir = $request->jam_berakhir;
        $room->penanggungjawab = $request->penanggungjawab;
        $room->img = $filename;
        $room->save();

        return redirect('/userDashboard')->with('success', 'Pesan Ruangan Berhasil~');
    }


}
