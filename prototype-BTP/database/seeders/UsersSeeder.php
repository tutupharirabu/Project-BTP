<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id_users' => "75dc9697-d474-4707-88ef-f36cf00fdf58",
            'username'  => 'Petugas BTP',
            'email' => 'petugasBTP@gmail.com',
            'role' => 'Admin',
            'nama_lengkap' => 'Petugas BTP',
            'password' => Hash::make('Admin123!465$'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
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
