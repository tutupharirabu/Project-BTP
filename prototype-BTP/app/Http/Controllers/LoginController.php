<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\OtpMail;
use App\Models\Otp;
use Illuminate\Support\Carbon;
use Twilio\Rest\Client;

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
            Otp::create([
            'id_users' => Auth::user()->id_users,
            'otp_code' => $otp,
            'expired_at' => Carbon::now()->addMinutes(2),
        ]);
        Mail::to(Auth::user()->email)->send(new OtpMail($otp));
        return redirect('/otp')->with('success', 'Kode OTP telah dikirim ke email Anda.');
        }

        if (Auth::attempt($credentials) && Auth::user()->role == 'penyewa') {
            $request->session()->regenerate();

            $request->session()->put('id_users', Auth::user()->id);
            $request->session()->put('email', Auth::user()->email);

            return redirect()->intended('/');
        }

        return back()->with('loginError', 'Login Failed~');
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

    public function authotp(Request $request){
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

    public function resendOtp(Request $request){
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

    public function otpWhatsappForm(){
    $otp = Otp::where('id_users', Auth::id())
              ->where('expired_at', '>', Carbon::now())
              ->latest()
              ->first();

    if (!$otp) {
        return redirect()->route('login')->with('loginError', 'OTP WhatsApp sudah kadaluarsa.');
    }

    return view('loginsys.otpwhatsapp', [
        'title' => 'OTP WhatsApp',
        'active' => 'otp-whatsapp',
        'expiredAt' => $otp->expired_at
    ]);
}

    public function otpwhatsapp(Request $request){
        if (!Auth::check()) {
            return redirect()->route('login')->with('loginError', 'Silakan login terlebih dahulu.');
    }
    $user = Auth::user();
    $userId = $user->id_users;
    $existingOtp = Otp::where('id_users', $userId)
                    ->where('expired_at', '>', Carbon::now())
                    ->latest()
                    ->first();
    if ($existingOtp) {
        return back()->withErrors(['otp' => 'Kode OTP sebelumnya masih berlaku. Mohon tunggu beberapa saat.']);
    }

    $otpCode = rand(100000, 999999);
        Otp::create([
            'id_users' => $userId,
            'otp_code' => $otpCode,
            'expired_at' => Carbon::now()->addMinutes(2),
        ]);

        try {
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $from   = env('TWILIO_WHATSAPP_NUMBER');
        $twilio = new \Twilio\Rest\Client($sid, $token);

        // ✅ Panggil nomor user dari kolom 'nomor' di tabel users
        $twilio->messages->create(
            "whatsapp:" . $user->phone_number,  
            [
                "from" => $from,
                "body" => "Kode OTP Anda adalah: $otpCode (berlaku 2 menit)"
            ]
        );
    } catch (\Exception $e) {
        return back()->with('loginError', 'Gagal mengirim OTP via WhatsApp: ' . $e->getMessage());
    }

    return redirect()->route('otp.whatsapp.form')->with('success', 'Kode OTP baru telah dikirim via WhatsApp.');
    }
    
    public function authwhatsapp(Request $request){
        $otp = Otp::where('user_id', $request->user_id)
                  ->where('otp', $request->otp)
                  ->where('expired_at', '>', Carbon::now())
                  ->first();

        if ($otp) {
            return redirect()->route('dashboard'); // sesuaikan tujuan
        } else {
            return back()->withErrors(['otp' => 'OTP WhatsApp tidak valid atau sudah kadaluarsa']);
        }
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
