<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenyewaDaftarRuangan extends Controller
{
    public function index()
    {
        return view('penyewa.daftarRuanganPenyewa');
    }

}
