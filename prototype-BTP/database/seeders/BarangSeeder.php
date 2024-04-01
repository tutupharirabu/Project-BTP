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

        for ($i=1; $i <= 10 ; $i++) {
            $namaBarang = $faker->randomElement(['sound system', 'kursi', 'meja', 'proyektor']);
            $jumlahBarang = $faker->numberBetween(1, 100);

            DB::table('barang')->insert([
                'nama_barang'  => $namaBarang,
                'jumlah_barang' => $jumlahBarang,
            ]);
        }

    }
}
