<?php

namespace Database\Seeders;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\PeminjamanSession;
use App\Models\Ruangan;
use App\Models\Users;
use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Enums\Database\UsersDatabaseColumn;

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = Users::query()->get();
        if ($users->isEmpty()) {
            $users = Users::factory()->count(5)->create();
        }

        $ruangan = Ruangan::query()->get();
        if ($ruangan->isEmpty()) {
            $ruangan = Ruangan::factory()->count(15)->create();
        }

        $peminjamanCollection = Peminjaman::factory()
            ->count(50)
            ->state(function () use ($users, $ruangan) {
                $user = $users->random();
                $ruang = $ruangan->random();

                $start = Carbon::now()
                    ->addDays(random_int(1, 60))
                    ->setHour(random_int(8, 18))
                    ->setMinute(0)
                    ->setSecond(0);

                $end = (clone $start)->addHours(random_int(2, 12));

                return [
                    UsersDatabaseColumn::IdUsers->value => $user->getKey(),
                    RuanganDatabaseColumn::IdRuangan->value => $ruang->getKey(),
                    PeminjamanDatabaseColumn::TanggalMulai->value => $start->format('Y-m-d H:i:s'),
                    PeminjamanDatabaseColumn::TanggalSelesai->value => $end->format('Y-m-d H:i:s'),
                ];
            })
            ->create();

        $peminjamanCollection->each(function (Peminjaman $peminjaman) {
            $sessionCount = Arr::random([0, 1, 2, 3]);
            if ($sessionCount === 0) {
                return;
            }

            $start = Carbon::parse($peminjaman->{PeminjamanDatabaseColumn::TanggalMulai->value});

            for ($i = 0; $i < $sessionCount; $i++) {
                $sessionStart = (clone $start)->addHours($i * 2);
                $sessionEnd = (clone $sessionStart)->addHour();

                PeminjamanSession::create([
                    'peminjaman_id' => $peminjaman->{PeminjamanDatabaseColumn::IdPeminjaman->value},
                    'tanggal_mulai' => $sessionStart,
                    'tanggal_selesai' => $sessionEnd,
                    'session_label' => sprintf('Sesi %d', $i + 1),
                ]);
            }
        });
    }
}
