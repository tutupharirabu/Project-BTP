<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class PenyewaDetailRuangan extends Controller
{
    public function show($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('penyewa.detailRuanganPenyewa', compact('ruangan'));
    }
}
