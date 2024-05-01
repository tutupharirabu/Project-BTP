<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class GambarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i=1; $i <= 10 ; $i++) {
            $id_ruangan = $faker->numberBetween(1, 9);
            $id_barang = $faker->numberBetween(1, 7);

            DB::table('gambar')->insert([
                'id_ruangan'  => $id_ruangan,
                'id_barang' => $id_barang,
                'url' => $faker->imageUrl(),
            ]);
        }
    }
}
