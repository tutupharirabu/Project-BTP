<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminStatusPengajuanController extends Controller
{
    public function index()
    {
        $dataPeminjaman = Peminjaman::with(['ruangan', 'users'])
            ->orderBy('created_at', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('admin.statusPengajuanAdmin', compact('dataPeminjaman'));
    }

    public function update(Request $request, string $id)
    {
        $dataPeminjaman = Peminjaman::find($id);
        $pilih = $request->input('pilihan');
        $message = '';

        if (!$dataPeminjaman) {
            return redirect('/statusPengajuanAdmin')->with('error', 'Peminjaman tidak ditemukan!');
        }

        if ($pilih == 'terima') {
            // Check for conflicting bookings in the same room and time
            $conflictingBookings = Peminjaman::where('tanggal_mulai', '<=', $dataPeminjaman->tanggal_selesai)
                ->where('tanggal_selesai', '>=', $dataPeminjaman->tanggal_mulai)
                ->where('id_peminjaman', '!=', $id)
                ->where('id_ruangan', $dataPeminjaman->id_ruangan)
                ->where('status', 'Menunggu')
                ->get();

            $dataPeminjaman->status = 'Disetujui';
            $dataPeminjaman->ruangan->tersedia = '1';
            $dataPeminjaman->ruangan->status = 'Tersedia';
            $idUs = Auth::id();
            $dataPeminjaman->id_users = $idUs;
            $dataPeminjaman->ruangan->save();
            $dataPeminjaman->save();
            $message = 'Peminjaman diterima!';

            foreach ($conflictingBookings as $booking) {
                $booking->status = 'Ditolak';
                $idUs = Auth::id();
                $booking->id_users = $idUs;
                $booking->save();
            }
        } elseif ($pilih == 'tolak') {
            $dataPeminjaman->status = 'Ditolak';
            $idUs = Auth::id();
            $dataPeminjaman->id_users = $idUs;
            $dataPeminjaman->save();
            $message = 'Peminjaman ditolak!';
        }

        $dataPeminjaman->save();

        return redirect('/statusPengajuanAdmin')->with('message', $message);
    }

    public function finish(string $id){
        $dataPeminjaman = Peminjaman::find($id);

        if (!$dataPeminjaman) {
            return redirect('/statusPengajuanAdmin')->with('error', 'Peminjaman tidak ditemukan!');
        }

        $dataPeminjaman->status = 'Selesai';
        $dataPeminjaman->ruangan->tersedia = '1';
        $dataPeminjaman->ruangan->status = 'Tersedia';
        $idUs = Auth::id();
        $dataPeminjaman->id_users = $idUs;
        $dataPeminjaman->ruangan->save();
        $dataPeminjaman->save();

        return redirect('/statusPengajuanAdmin')->with('message', 'Peminjaman selesai!');
    }
}
