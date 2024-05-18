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

        // if (Auth::guard('admin')->attempt($credentials)) {
        //     $request->session()->regenerate();

        //     return redirect()->intended('/adminRuangan');
        // }

        // if (Auth::guard('penyewa')->attempt($credentials)) {
        //     $request->session()->regenerate();

        //     $request->session()->put('id_users', Auth::guard('penyewa')->user()->id);
        //     $request->session()->put('email', Auth::guard('penyewa')->user()->email);

        //     return redirect()->intended('/dashboardPenyewa');
        // }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'admin') {
                $request->session()->put('id_users', Auth::user()->id);
                $request->session()->put('email', Auth::user()->email);

                return redirect()->intended('/dashboardPenyewa'); // jangan lupa dia harusnya /adminRuangan

            } else if (Auth::user()->role == 'Petugas') {
                $request->session()->put('id_users', Auth::user()->id);
                $request->session()->put('email', Auth::user()->email);

                return redirect()->intended('/dashboardPenyewa'); // jangan lupa dia harusnya /adminRuangan

            } else if (Auth::user()->role == 'Penyewa') {
                $request->session()->put('id_users', Auth::user()->id);
                $request->session()->put('email', Auth::user()->email);

                return redirect()->intended('/dashboardPenyewa');
            }
        }

        return back()->with('loginError', 'Login Failed~');
    }

    public function logout(Request $request){
        $request->session()->forget('id_users');
        $request->session()->forget('email');

        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
