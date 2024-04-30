<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class mengelolaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i=1; $i <= 10 ; $i++) {
            $id = $faker->numberBetween(1, 10);

            DB::table('mengelola')->insert([
                'id_petugas'  => $id,
                'id_ruangan' => $id,
                'id_barang' => $id,
            ]);
        }

    }
}
