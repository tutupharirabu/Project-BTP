<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\RoomLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $borrow_date_start = Carbon::createFromFormat('d/m/Y', $request->borrow_date_start)->format('Y-m-d');
        $borrow_date_end = Carbon::createFromFormat('d/m/Y', $request->borrow_date_end)->format('Y-m-d');

        $room = new RoomLogs;
        $room->user_id = Auth::id();
        $room->room_id = $ruang;
        $room->keperluan = $request->keperluan;
        $room->jumlahPesertaPanitia = $request->jumlahPesertaPanitia;
        $room->borrow_date_start = $borrow_date_start;
        $room->borrow_date_end = $borrow_date_end;
        $room->jam_mulai = $request->jam_mulai;
        $room->jam_berakhir = $request->jam_berakhir;
        $room->penanggungjawab = $request->penanggungjawab;
        $room->img = $filename;
        $room->save();

        return redirect('/userDashboard')->with('success', 'Pesan Ruangan Berhasil~');
    }


}
