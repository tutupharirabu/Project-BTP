<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $rooms = ['Rent Office (Private Space)', 'Coworking Space (Shared Space)', 'Coworking Space (Private Room)', 'Virtual Office', 'Multimedia', 'Aula', 'R. Meeting', 'Training Room', 'Overtime Room'];
        shuffle($rooms);

        for ($i=1; $i <= 9 ; $i++) {
            $namaRuangan = $rooms[$i-1];
            $kapasitasRuangan = $faker->numberBetween(1, 100);
            $hargaRuangan = $faker->numberBetween(10000, 1000000);

            if($namaRuangan == 'Rent Office (Private Space)'){
                $lokasi = 'Gedung B dan C';
            }elseif ($namaRuangan == 'Coworking Space (Shared Space)') {
                $lokasi = 'Gedung B Lt. 1';
            } elseif ($namaRuangan == 'Coworking Space (Shared Space)' || $namaRuangan == 'Coworking Space (Private Room)') {
                $lokasi = 'Gedung D Lt. 2';
            } elseif ($namaRuangan == 'Coworking Space (Private Room)') {
                $lokasi = 'Gedung D Lt. 2';
            } elseif ($namaRuangan == 'Multimedia') {
                $lokasi = 'Gedung A';
            } elseif ($namaRuangan == 'Aula') {
                $lokasi = 'Gedung C Lt. 2';
            } elseif ($namaRuangan == 'R. Meeting' || $namaRuangan == 'Training Room') {
                $lokasi = 'Gedung B Lt. 2';
            } else {
                $lokasi = '-';
            }


            DB::table('ruangan')->insert([
                'nama_ruangan'  => $namaRuangan,
                'kapasitas_ruangan' => $kapasitasRuangan,
                'lokasi' => $lokasi,
                'harga_ruangan' => $hargaRuangan,
                'tersedia' => true,
            ]);
        }
    }
}
