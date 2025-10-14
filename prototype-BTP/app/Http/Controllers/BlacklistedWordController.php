<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlacklistedWord;

class BlacklistedWordController extends Controller
{
    public function index()
    {
        $words = BlacklistedWord::all();
        return view('admin.blacklisted_words.index', compact('words'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'word' => 'required|string|unique:blacklisted_words,word',
        ]);

        BlacklistedWord::create($request->only('word'));

        return redirect()->back()->with('success', 'Kata berhasil ditambahkan ke daftar blacklist.');
    }

    public function destroy($id)
    {
        BlacklistedWord::destroy($id);
        return redirect()->back()->with('success', 'Kata berhasil dihapus dari daftar blacklist.');
    }
}
