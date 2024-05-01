<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // for ($i=1; $i <= 10; $i++) {
        //     $gender = $faker->randomElement(['male', 'female']);

        //     DB::table('admin')->insert([
        //         'nama_lengkap'  => $faker->name,
        //         'jenis_kelamin' => $gender,
        //         'nomor_telepon' => preg_replace("/[^0-9]/", "", $faker->phoneNumber),
        //         'alamat' => $faker->address,
        //         'email' => $faker->safeEmail,
        //         'password' => Hash::make('password'),
        //     ]);
        // }

        DB::table('admin')->insert([
            'nama_lengkap'  => 'Muhammad Fadhil Ardiansyah Supiyan',
            'jenis_kelamin' => 'Male',
            'nomor_telepon' => preg_replace("/[^0-9]/", "", $faker->phoneNumber),
            'alamat' => $faker->address,
            'email' => 'mfadhiladmin@gmail.com',
            'password' => Hash::make('fadhiladminaja123'),
        ]);

        DB::table('admin')->insert([
            'nama_lengkap'  => 'Irfan Zharauri Nanda Sudiyanto',
            'jenis_kelamin' => 'Male',
            'nomor_telepon' => preg_replace("/[^0-9]/", "", $faker->phoneNumber),
            'alamat' => $faker->address,
            'email' => 'code.zharaurien@gmail.com',
            'password' => Hash::make('inipasswordya?'),
        ]);

        DB::table('admin')->insert([
            'nama_lengkap'  => 'Hafiz Yazid Muhammad',
            'jenis_kelamin' => 'Male',
            'nomor_telepon' => preg_replace("/[^0-9]/", "", $faker->phoneNumber),
            'alamat' => $faker->address,
            'email' => 'yazidn@gmail.com',
            'password' => Hash::make('password'),
        ]);

    }
}
