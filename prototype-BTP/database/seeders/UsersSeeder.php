<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id_users' => uuid_create(4),
            'username'  => 'Petugas BTP',
            'email' => 'petugasBTP@gmail.com',
            'role' => 'admin',
            'nama_lengkap' => 'Petugas BTP',
            'password' => Hash::make('admin123!'),
        ]);

        // DB::table('users')->insert([
        //     'username'  => 'tutupharirabu',
        //     'email' => 'code.zharaurien@gmail.com',
        //     'role' => 'admin',
        //     'nama_lengkap' => 'Irfan Zharauri Nanda Sudiyanto',
        //     'password' => Hash::make('inipasswordya?'),
        // ]);

        // $faker = Faker::create('id_ID');
        // for ($i=1; $i <= 10 ; $i++) {
        //     $role = $faker->randomElement(['Penyewa', 'Petugas']);

        //     DB::table('users')->insert([
        //         'username'  => $faker->userName,
        //         'email' => $faker->email,
        //         'role' => $role,
        //         'nama_lengkap' => $faker->name,
        //         'password' => Hash::make('password'),
        //     ]);
        // }

    }
}
