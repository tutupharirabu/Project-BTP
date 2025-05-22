<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Ruangan;
use App\Models\Peminjaman;
use Illuminate\Console\Command;

class UpdateRuanganStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-ruangan-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        Ruangan::chunk(100, function ($ruangans) use ($now) {
            foreach ($ruangans as $r) {
                // === Cek jika ada group_id_ruangan ===
                if ($r->group_id_ruangan) {
                    // Group-aware logic untuk semua ruangan yg satu group
                    $groupRuanganIds = Ruangan::where('group_id_ruangan', $r->group_id_ruangan)
                        ->pluck('id_ruangan')
                        ->toArray();

                    // Logika: khusus coworking, cek status penuh
                    if (stripos($r->nama_ruangan, 'coworking') !== false) {
                        $kapasitas = Ruangan::whereIn('id_ruangan', $groupRuanganIds)->min('kapasitas_maksimal');
                        $booked = Peminjaman::whereIn('id_ruangan', $groupRuanganIds)
                            ->where('status', 'Disetujui')
                            ->whereDate('tanggal_mulai', '<=', $now->toDateString())
                            ->whereDate('tanggal_selesai', '>=', $now->toDateString())
                            ->sum('jumlah');

                        if ($booked >= $kapasitas) {
                            $r->status = 'Penuh';
                        } else {
                            $r->status = 'Tersedia';
                        }
                    } else {
                        // Untuk ruangan satu group, tapi bukan coworking
                        $isUsed = Peminjaman::whereIn('id_ruangan', $groupRuanganIds)
                            ->where('status', 'Disetujui')
                            ->where('tanggal_mulai', '<=', $now)
                            ->where('tanggal_selesai', '>=', $now)
                            ->exists();
                        $r->status = $isUsed ? 'Digunakan' : 'Tersedia';
                    }
                } else {
                    // Ruangan tanpa group id, logika klasik
                    $isUsed = Peminjaman::where('id_ruangan', $r->id_ruangan)
                        ->where('status', 'Disetujui')
                        ->where('tanggal_mulai', '<=', $now)
                        ->where('tanggal_selesai', '>=', $now)
                        ->exists();
                    $r->status = $isUsed ? 'Digunakan' : 'Tersedia';
                }
                $r->save();
            }
        });
    }
}
