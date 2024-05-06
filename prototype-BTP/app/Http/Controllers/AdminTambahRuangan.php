<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminTambahRuangan extends Controller
{
    public function index()
    {
        return view('admin.tambahRuanganAdmin');
    }
    public function store(Request $req){
        $image = $req->file('file');
        $imageName = time().rand(1,100).'.'.$image->extension();
        $image->move(public_path('image'),$imageName);
        return response()->json(['success'=>$imageName]);
    }
}
