<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $items = ['Sound System', 'Kursi', 'Meja', 'Proyektor'];
        shuffle($items);

        for ($i=1; $i <= 4 ; $i++) {
            $namaBarang = $items[$i-1];
            $jumlahBarang = $faker->numberBetween(1, 100);
            $fotoBarang = $faker->imageUrl($width = 640, $height = 480);

            DB::table('barang')->insert([
                'nama_barang'  => $namaBarang,
                'jumlah_barang' => $jumlahBarang,
                'foto_barang' => $fotoBarang,
            ]);
        }

    }
}
