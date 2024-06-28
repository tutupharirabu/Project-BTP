<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminStatusPengajuanController extends Controller
{
    public function index()
    {
        $dataPeminjaman = Peminjaman::with('ruangan')->get();
        return view('admin.statusPengajuanAdmin', compact('dataPeminjaman'));
    }

    public function update(Request $request, string $id)
    {
        $dataPeminjaman = Peminjaman::find($id);
        $pilih = $request->input('pilihan');

        if ($pilih == 'terima') {
            // Check for existing approved bookings at the same time
            $conflictingBookings = Peminjaman::where('tanggal_mulai', '<=', $dataPeminjaman->tanggal_selesai)
                ->where('tanggal_selesai', '>=', $dataPeminjaman->tanggal_mulai)
                ->where('id_peminjaman', '!=', $id)
                ->where('status', 'Menunggu')
                ->get();

            $dataPeminjaman->status = 'Disetujui';
            $dataPeminjaman->ruangan->tersedia = '0';
            $dataPeminjaman->save();
            $message = 'Peminjaman diterima!';

            foreach ($conflictingBookings as $booking) {
                $booking->status = 'Ditolak';
                $booking->save();
                $message = 'Peminjaman ditolak!';
            }
        } elseif ($pilih == 'tolak') {
            $dataPeminjaman->status = 'Ditolak';
            $dataPeminjaman->ruangan->save();
            $message = 'Peminjaman ditolak!';
        }


        // if ($conflictingBooking) {
        //     return redirect()->back()->with('error', 'Ruangan sudah dipinjam pada waktu tersebut.');
        // }
        // else if($pilih == 'terima') {
        //     $dataPeminjaman->status = 'Disetujui';
        //     $dataPeminjaman->ruangan->tersedia = '0';
        //     $dataPeminjaman->ruangan->save();
        //     $message = 'Peminjaman diterima!';
        // } else if ($pilih == 'tolak') {
        //     $dataPeminjaman->status = 'Ditolak';
        //     $dataPeminjaman->ruangan->save();
        //     $message = 'Peminjaman ditolak!';
        // }

        // } else if ($pilih == 'tinjau ulang') {
        //     $dataMeminjam->status = 'Meninjau Kembali Pengajuan';
        //     $message = 'Mohon maaf, pengajuan sedang ditinjau kembali!';
        // } else if ($pilih == 'ulang') {
        //     $dataMeminjam->status = 'Sedang Menunggu';
        // }

        $dataPeminjaman->save();

        return redirect('/statusPengajuanAdmin');
    }
}
