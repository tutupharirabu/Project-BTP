<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PenyewaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i=1; $i <= 10; $i++) {
            $gender = $faker->randomElement(['male', 'female']);
            $status = $faker->randomElement(['mahasiswa', 'dosen', 'karyawan']);
            $inEx = '';

            if ($status == 'mahasiswa' || $status == 'dosen') {
                // Internal
                $inEx = 'Internal';
            } else {
                // Eksternal
                $inEx = 'Eksternal';
            }

            DB::table('penyewa')->insert([
                'nama_lengkap'  => $faker->name,
                'jenis_kelamin' => $gender,
                'instansi' => $faker->company,
                'status' => $inEx,
                'alamat' => $faker->address,
                'email' => $faker->safeEmail,
                'password' => Hash::make('password'),
            ]);
        }
    }
}
