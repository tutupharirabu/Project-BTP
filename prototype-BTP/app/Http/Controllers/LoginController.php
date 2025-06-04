<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // ✅ Add this line
use Carbon\Carbon; // ✅ Also needed if you're using now() or Carbon::now()

class LoginController extends Controller
{
    public function index() {
        return view('loginsys.login', [
            'title' => 'login',
            'active' => 'login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $ip = $request->ip();

        // ✅ Check if this IP is currently blocked
        $record = DB::table('failed_logins')->where('ip', $ip)->first();
        if ($record && $record->blocked_until && Carbon::now()->lt($record->blocked_until)) {
            return back()->with('loginError', 'Too many login attempts. Try again later.');
        }

        // ✅ Validate credentials
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // ✅ Admin/Petugas login
        if (Auth::attempt($credentials) && (Auth::user()->role == 'admin' || Auth::user()->role == 'petugas')) {
            $request->session()->regenerate();
            DB::table('failed_logins')->where('ip', $ip)->delete(); // ✅ Clear record on success
            return redirect()->intended('/dashboardAdmin');
        }

        // ✅ Penyewa login
        if (Auth::attempt($credentials) && Auth::user()->role == 'penyewa') {
            $request->session()->regenerate();
            DB::table('failed_logins')->where('ip', $ip)->delete(); // ✅ Clear record on success
            $request->session()->put('id_users', Auth::user()->id);
            $request->session()->put('email', Auth::user()->email);
            return redirect()->intended('/');
        }

        // ❌ Failed login → update or insert record
        if ($record) {
            $attempts = $record->attempts + 1;
            $blockedUntil = $attempts >= 5 ? now()->addMinutes(15) : null;

            DB::table('failed_logins')->where('ip', $ip)->update([
                'attempts' => $attempts,
                'last_attempt_at' => now(),
                'blocked_until' => $blockedUntil,
                'updated_at' => now()
            ]);
        } else {
            DB::table('failed_logins')->insert([
                'ip' => $ip,
                'attempts' => 1,
                'last_attempt_at' => now(),
                'blocked_until' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
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
