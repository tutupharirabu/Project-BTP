<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminStatusPengajuanController extends Controller
{
    public function index()
    {
        $dataPeminjaman = Peminjaman::with('ruangan')->paginate(10);
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
            $dataPeminjaman->ruangan->tersedia = '0';
            $dataPeminjaman->save();
            $message = 'Peminjaman diterima!';

            foreach ($conflictingBookings as $booking) {
                $booking->status = 'Ditolak';
                $booking->save();
            }
        } elseif ($pilih == 'tolak') {
            $dataPeminjaman->status = 'Ditolak';
            $dataPeminjaman->save();
            $message = 'Peminjaman ditolak!';
        }

        $dataPeminjaman->save();

        return redirect('/statusPengajuanAdmin')->with('message', $message);
    }
}
