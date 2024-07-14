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

        $rooms = ['Rent Office (Private Space)', 'Coworking Space (Shared Space)', 'Coworking Space (Private Room)', 'Virtual Office', 'Multimedia Room', 'Aula', 'Meeting Room', 'Training Room', 'Overtime Room', 'Coworking Space (Shared Space)'];
        shuffle($rooms);

        for ($i = 1; $i <= 10 ; $i++) {
            $namaRuangan = $rooms[$i-1];
            $kapasitasRuangan = $faker->numberBetween(10, 100);

            if ($namaRuangan == 'Rent Office (Private Space)') {
                $lokasi = 'Gedung B dan C';
                $hargaRuangan = 1000000;

                DB::table('ruangan')->insert([
                    'nama_ruangan'  => $namaRuangan,
                    'kapasitas_ruangan' => $kapasitasRuangan,
                    'lokasi' => $lokasi,
                    'harga_ruangan' => $hargaRuangan,
                    'tersedia' => true,
                    'status' => '-',
                ]);
            } elseif ($namaRuangan == 'Coworking Space (Private Room)') {
                $lokasi = 'Gedung D Lt. 2';
                $hargaRuangan = 2350000;

                DB::table('ruangan')->insert([
                    'nama_ruangan'  => $namaRuangan,
                    'kapasitas_ruangan' => $kapasitasRuangan,
                    'lokasi' => $lokasi,
                    'harga_ruangan' => $hargaRuangan,
                    'tersedia' => true,
                    'status' => '-',
                ]);
            } elseif ($namaRuangan == 'Multimedia Room') {
                $lokasi = 'Gedung A';
                $hargaRuangan = 500000;

                DB::table('ruangan')->insert([
                    'nama_ruangan'  => $namaRuangan,
                    'kapasitas_ruangan' => $kapasitasRuangan,
                    'lokasi' => $lokasi,
                    'harga_ruangan' => $hargaRuangan,
                    'tersedia' => true,
                    'status' => '-',
                ]);
            } elseif ($namaRuangan == 'Aula') {
                $lokasi = 'Gedung C Lt. 2';
                $hargaRuangan = 650000;

                DB::table('ruangan')->insert([
                    'nama_ruangan'  => $namaRuangan,
                    'kapasitas_ruangan' => $kapasitasRuangan,
                    'lokasi' => $lokasi,
                    'harga_ruangan' => $hargaRuangan,
                    'tersedia' => true,
                    'status' => '-',
                ]);
            } elseif ($namaRuangan == 'Meeting Room') {
                $lokasi = 'Gedung B Lt. 2';
                $hargaRuangan = 500000;

                DB::table('ruangan')->insert([
                    'nama_ruangan'  => $namaRuangan,
                    'kapasitas_ruangan' => $kapasitasRuangan,
                    'lokasi' => $lokasi,
                    'harga_ruangan' => $hargaRuangan,
                    'tersedia' => true,
                    'status' => '-',
                ]);
            } elseif ($namaRuangan == 'Training Room') {
                $lokasi = 'Gedung B Lt. 2';
                $hargaRuangan = 300000;

                DB::table('ruangan')->insert([
                    'nama_ruangan'  => $namaRuangan,
                    'kapasitas_ruangan' => $kapasitasRuangan,
                    'lokasi' => $lokasi,
                    'harga_ruangan' => $hargaRuangan,
                    'tersedia' => true,
                    'status' => '-',
                ]);
            } elseif ($namaRuangan == 'Virtual Office') {
                $lokasi = '-';
                $hargaRuangan = 200000;

                DB::table('ruangan')->insert([
                    'nama_ruangan'  => $namaRuangan,
                    'kapasitas_ruangan' => $kapasitasRuangan,
                    'lokasi' => $lokasi,
                    'harga_ruangan' => $hargaRuangan,
                    'tersedia' => true,
                    'status' => '-',
                ]);
            } elseif ($namaRuangan == 'Overtime Room') {
                $lokasi = '-';
                $hargaRuangan = 200000;

                DB::table('ruangan')->insert([
                    'nama_ruangan'  => $namaRuangan,
                    'kapasitas_ruangan' => $kapasitasRuangan,
                    'lokasi' => $lokasi,
                    'harga_ruangan' => $hargaRuangan,
                    'tersedia' => true,
                    'status' => '-',
                ]);

            } elseif ($namaRuangan == 'Coworking Space (Shared Space)') {
                $dataruangan = [
                    ['lokasi' => 'Gedung B Lt. 1', 'harga' => 350000],
                    ['lokasi' => 'Gedung D Lt. 2', 'harga' => 500000]
                ];

                foreach ($dataruangan as $data) {
                    $existingRoom = DB::table('ruangan')->where('lokasi', $data['lokasi'])->first();

                    if (!$existingRoom) {
                        DB::table('ruangan')->insert([
                            'nama_ruangan' => $namaRuangan,
                            'kapasitas_ruangan' => $kapasitasRuangan,
                            'lokasi' => $data['lokasi'],
                            'harga_ruangan' => $data['harga'],
                            'tersedia' => true,
                            'status' => '-',
                        ]);
                    }
                }
            }
        }
    }
}
