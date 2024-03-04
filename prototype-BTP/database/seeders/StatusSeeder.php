<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Status::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            'Tenaga Pendidik (Dosen)', 'Tenaga Kependidikan (TPA)', 'Mahasiswa', 'Umum'
        ];

        foreach ($data as $value) {
            Status::insert([
                'name' => $value
            ]);
        }
    }
}
