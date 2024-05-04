<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminTambahRuangan extends Controller
{
    public function index()
    {
        return view('admin.tambahRuanganAdmin');
    }
}
