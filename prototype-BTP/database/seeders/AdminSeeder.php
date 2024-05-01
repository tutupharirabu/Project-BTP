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

        DB::table('users')->insert([
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

    }
}
