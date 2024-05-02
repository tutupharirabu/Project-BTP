<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenyewaDetailRuangan extends Controller
{
    public function index()
    {
        return view('penyewa.detailRuanganPenyewa');
    }
}
