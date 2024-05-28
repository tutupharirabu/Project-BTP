<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class PenyewaDaftarRuangan extends Controller
{
    public function index()
    {
        $dataRuangan = Ruangan::all();
        return view('penyewa.daftarRuanganPenyewa', compact('dataRuangan'));
    }
}
