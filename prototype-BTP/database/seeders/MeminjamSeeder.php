<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class MeminjamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i=1; $i <= 10 ; $i++) {
            $tanggal = $faker->date();
            $jumlahPengguna = $faker->numberBetween(1, 100);
            $id = $faker->numberBetween(1, 10);

            DB::table('meminjam')->insert([
                'tanggal_peminjaman'  => $tanggal,
                'tanggal_selesai'  => $tanggal,
                'jumlah_pengguna' => $jumlahPengguna,
                'id_penyewa' => $id,
                'id_barang' => $id,
                'id_ruangan' => $id,
            ]);
        }
    }
}
