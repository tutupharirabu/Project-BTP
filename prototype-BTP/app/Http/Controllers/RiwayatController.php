<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;

class RiwayatController extends Controller
{
    public function index()
    {
        $dataRuangan = Ruangan::all();
        return view('riwayatRuangan', compact('dataRuangan'));
    }
}
