<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use DB;
use App\Models\Ruangan;

class DashboardPenyewaController extends Controller
{
    public function index()
    {
        $RuangDashboard = Ruangan::all();

        $peminjamans = Peminjaman::with('ruangan')->where('status','Disetujui')->get();

        $events = array();
        foreach($peminjamans as $peminjaman){
            $events[] = [
                'title' => $peminjaman->nama_peminjam.' '.$peminjaman->ruangan->nama_ruangan,
                'start' => $peminjaman->tanggal_mulai,
                'end' => $peminjaman->tanggal_selesai,
            ];
        }
        return view('penyewa/userDashboard', compact('peminjamans','events','RuangDashboard'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

