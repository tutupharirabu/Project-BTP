<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Ruangan;
use App\Models\Peminjaman;
use App\Enums\StatusRuangan;
use App\Enums\StatusPeminjaman;
use Illuminate\Console\Command;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Enums\Database\PeminjamanDatabaseColumn;

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
                    $groupRuanganIds = Ruangan::where(RuanganDatabaseColumn::GroupIdRuangan->value, $r->group_id_ruangan)
                        ->pluck(RuanganDatabaseColumn::IdRuangan->value)
                        ->toArray();

                    // Logika: khusus coworking, cek status penuh
                    if (stripos($r->nama_ruangan, 'coworking') !== false) {
                        $kapasitas = Ruangan::whereIn(RuanganDatabaseColumn::IdRuangan->value, $groupRuanganIds)->min(RuanganDatabaseColumn::KapasitasMaksimal->value);
                        $booked = Peminjaman::whereIn(RuanganDatabaseColumn::IdRuangan->value, $groupRuanganIds)
                            ->where(PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value, StatusPeminjaman::Disetujui->value)
                            ->whereDate(PeminjamanDatabaseColumn::TanggalMulai->value, '<=', $now->toDateString())
                            ->whereDate(PeminjamanDatabaseColumn::TanggalSelesai->value, '>=', $now->toDateString())
                            ->sum(PeminjamanDatabaseColumn::JumlahPeserta->value);

                        if ($booked >= $kapasitas) {
                            $r->status = StatusRuangan::Penuh->value;
                        } else {
                            $r->status = StatusRuangan::Tersedia->value;
                        }
                    } else {
                        // Untuk ruangan satu group, tapi bukan coworking
                        $isUsed = Peminjaman::whereIn(RuanganDatabaseColumn::IdRuangan->value, $groupRuanganIds)
                            ->where(PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value, StatusPeminjaman::Disetujui->value)
                            ->where(PeminjamanDatabaseColumn::TanggalMulai->value, '<=', $now)
                            ->where(PeminjamanDatabaseColumn::TanggalSelesai->value, '>=', $now)
                            ->exists();
                        $r->status = $isUsed ? StatusRuangan::Digunakan->value : StatusRuangan::Tersedia->value;
                    }
                } else {
                    // Ruangan tanpa group id, logika klasik
                    $isUsed = Peminjaman::where(RuanganDatabaseColumn::IdRuangan->value, $r->id_ruangan)
                        ->where(PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value, StatusPeminjaman::Disetujui->value)
                        ->where(PeminjamanDatabaseColumn::TanggalMulai->value, '<=', $now)
                        ->where(PeminjamanDatabaseColumn::TanggalSelesai->value, '>=', $now)
                        ->exists();
                    $r->status = $isUsed ? StatusRuangan::Digunakan->value : StatusRuangan::Tersedia->value;
                }
                $r->save();
            }
        });
    }
}
