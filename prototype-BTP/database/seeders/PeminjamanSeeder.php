<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;


class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i=1; $i <= 10 ; $i++) {
            $id_users = $faker->numberBetween(1, 10);
            $id_ruangan = $faker->numberBetween(1, 9);
            $id_barang = $faker->numberBetween(1, 7);
            $tanggal = $faker->dateTime();
            $jumlah = $faker->numberBetween(1, 100);
            $status = $faker->randomElement(['Available', 'Booked', 'Waiting']);

            DB::table('peminjaman')->insert([
                'id_users'  => $id_users,
                'id_ruangan' => $id_ruangan,
                'id_barang' => $id_barang,
                'tanggal_mulai'  => $tanggal,
                'tanggal_selesai'  => $tanggal,
                'jumlah' => $jumlah,
                'status' => $status,
                'Keterangan' => "-",
            ]);
        }
    }
}
