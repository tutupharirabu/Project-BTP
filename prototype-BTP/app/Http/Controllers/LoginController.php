<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\Otp;
use Illuminate\Support\Carbon;

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

        if (Auth::attempt($credentials) && ((Auth::user()->role == 'admin' || Auth::user()->role == 'petugas'))) {
            $request->session()->regenerate();
            $otp = rand(100000, 999999);
             return response()->json([
                'success' => true,
                'message' => 'login berhasil'
             ]);
            }
             return response()-> json([
                'success' => false,
                'message' => 'login error'
             ], 401);
    }

    public function sendOtp(Request $request){
        if(!Auth::check()){
            return response()->json(['success' => false, 'message' => 'login error'], 401);
        }
        $request -> validate([
            'method' => 'required|in:email,whatsapp,telegram'
        ]);

        $otp = rand(100000, 999999);
        $method = $request->input('method');

        Otp::create([
            'id_users' => Auth::user()->id_users,
            'otp_code' => $otp,
            'expired_at' => Carbon::now()->addMinutes(2),
            ]);

        if($method === 'email'){
            Mail::to(Auth::user()->email)->send(new OtpMail($otp));
        } elseif( $method === 'whatsapp'){
            //...
        } elseif( $method === 'telegram'){
            //...
        }
        return response()->json([
            'success' => true,
            'message' => 'kode otp berhasil dikirim',
            'redirect' => url('/otp')
        ]);
    }

    public function otp(Request $request){
        if (!Auth::check()) {
        return redirect()->route('login')->with('loginError', 'Silakan login terlebih dahulu.');
    }
    $otp = Otp::where('id_users', Auth::id())
              ->where('expired_at', '>', Carbon::now())
              ->latest()
              ->first();

    if (!$otp) {
        return redirect()->route('login')->with('loginError', 'Akses tidak sah atau OTP telah kedaluwarsa.');
    }
        return view('loginsys.formotp', [
            'title' => 'otp',
            'active' => 'otp',
            'expiredAt' => $otp->expired_at
        ]);

    }


    public function authotp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        $inputOtp = $request->input('otp');
        $userId = Auth::id();
        $otpRecord = Otp::where('id_users', $userId)
                        ->where('otp_code', $inputOtp)
                        ->where('expired_at', '>',Carbon::now())
                        ->latest()
                        ->first();
        if ($otpRecord) {
            $otpRecord->delete();
            return redirect()->intended('/dashboardAdmin');
        }
        return back()->withErrors(['otp' => 'Kode OTP tidak sesuai atau sudah kadaluarsa.']);
    }

    public function resendOtp(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('loginError', 'Silakan login terlebih dahulu.');
    }

    $userId = Auth::id();

    $existingOtp = Otp::where('id_users', $userId)
                    ->where('expired_at', '>', Carbon::now())
                    ->latest()
                    ->first();

    if ($existingOtp) {
        return back()->withErrors(['otp' => 'Kode OTP sebelumnya masih berlaku. Mohon tunggu beberapa saat.']);
    }
    $otp = rand(100000, 999999);

    Otp::create([
        'id_users' => $userId,
        'otp_code' => $otp,
        'expired_at' => Carbon::now()->addMinutes(2),
    ]);
   Mail::to(Auth::user()->email)->send(new OtpMail($otp));

    return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
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
