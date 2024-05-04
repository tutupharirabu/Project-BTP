<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDetailRuangan extends Controller
{
    public function index()
    {
        return view('admin.detailRuanganAdmin');
    }
}
