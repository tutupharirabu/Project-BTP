<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Room::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            'Ruang Multimedia A', 'Ruang Rapat Besar Lantai 2 Gedung B', 'Ruang Rapat Pelatihan Lantai 2 Gedung B', 'Ruang Aula Lantai 2 Gedung C', 'Ruang Rapat Lantai Dasar Gedung C'
        ];

        foreach ($data as $value) {
            Room::insert([
                'title' => $value
            ]);
        }
    }
}
