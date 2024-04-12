<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() {
        return view('register', [
            'title' => 'Register',
            'active' => 'register'
        ]);
    }

    public function store(Request $request) {

        $request -> validate([
            'name' => 'required|max:255',
            'username' => 'required|min:3|max:255|unique:users',
            'email' => 'required|email|unique:users|email:dns',
            'password' => 'required|min:5|max:50',
            'telephone_number' => 'required|min:10|max:50',
            'instansi' => 'required|min:5|max:100',
        ]);

        $request['password'] = Hash::make($request['password']);

        $role = $request->input('kategoriRole');

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->telephone_number = $request->telephone_number;
        $user->instansi = $request->instansi;
        $user->role_id = $role;
        $user->save();

        return redirect('/')->with('success', 'Registration Successfull~ Please Login!');
    }
}
