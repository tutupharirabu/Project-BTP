<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('loginsys.login', [
            'title' => 'login',
            'active' => 'login'
        ]);
    }

    public function authenticate(Request $request) {

        $credentials = $request -> validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials) && ((Auth::user()->role == 'admin' || Auth::user()->role == 'Petugas'))) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboardAdmin');
        }

        if (Auth::attempt($credentials) && Auth::user()->role == 'Penyewa') {
            $request->session()->regenerate();

            $request->session()->put('id_users', Auth::user()->id);
            $request->session()->put('email', Auth::user()->email);

            return redirect()->intended('/');
        }

        return back()->with('loginError', 'Login Failed~');
    }

    public function logout(Request $request){
        $request->session()->forget('id_users');
        $request->session()->forget('email');

        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->intended('/');
    }
}
