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

        $items = ['Wireless 1', 'Wireless 2', 'Kursi Sofa', 'Meja Kecil Operator/Pelatihan', 'Meja Sofa', 'LCD Proyektor (dengan Kabel VGA Standar)', 'Layar Proyektor'];
        shuffle($items);

        $kondisi = ['Baik', 'Rusak Parah', 'Sedang Korslet', 'Baik Parah', 'Agak Laen', 'Setengah Rusak', 'Tidak Baik'];
        shuffle($kondisi);

        for ($i=1; $i <= 7 ; $i++) {
            $namaBarang = $items[$i-1];
            $jumlahBarang = $faker->numberBetween(1, 10);
            $kondisiBarang = $kondisi[$i-1];
            $hargaBarang = $faker->numberBetween(10000, 1000000);

            DB::table('barang')->insert([
                'nama_barang'  => $namaBarang,
                'jumlah_barang' => $jumlahBarang,
                'kondisi_barang' => $kondisiBarang,
                'harga_barang' => $hargaBarang,
                'tersedia' => true,
            ]);
        }

    }
}
