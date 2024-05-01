<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PengelolaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i=1; $i <= 10 ; $i++) {

            $id_users = $faker->numberBetween(1, 10);
            $id_barang = $faker->numberBetween(1, 7);
            $id_ruangan = $faker->numberBetween(1, 9);
            $tanggal = $faker->dateTime();
            $keterangan = $faker->randomElement(['Barang ini harus disimpan di ruang penyimpanan yang terkunci setelah digunakan untuk mencegah kerusakan atau pencurian.', 'Ruangan ini harus dijaga kebersihannya setiap hari dan dilakukan pembersihan menyeluruh setiap minggu.']);

            DB::table('pengelolaan')->insert([
                'id_users'  => $id_users,
                'id_barang' => $id_barang,
                'id_ruangan' => $id_ruangan,
                'tanggal' => $tanggal,
                'keterangan' => $keterangan,
            ]);
        }
    }
}
