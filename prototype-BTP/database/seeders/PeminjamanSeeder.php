<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Ruangan;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Locale Indonesia
        $roles = ['Pegawai', 'Mahasiswa', 'Umum'];
        $ruanganList = Ruangan::all();




        // $namaIndonesia = [
        //     'Budi', 'Siti', 'Agus', 'Ani', 'Eko', 'Sri', 'Yanto', 'Dewi',
        //     'Indra', 'Rina', 'Andi', 'Mira', 'Wawan', 'Nina', 'Arif', 'Reni',
        //     'Yudi', 'Tina', 'Hari', 'Lina'
        // ];

        foreach (range(1, 50) as $index) {
            $ruangan = $ruanganList->random();
            $tanggalMulai = Carbon::now()->subDays(rand(1, 30));
            $tanggalSelesai = (clone $tanggalMulai)->addHours(rand(1, 10));
            $jumlah = rand($ruangan->kapasitas_minimal, $ruangan->kapasitas_maksimal);

            $harga = $ruangan->harga_ruangan; // Harga total untuk peminjaman
            $Totalharga = $harga * 0.11 + 2500;

            DB::table('peminjaman')->insert([
                'nama_peminjam' => $faker->name,
                'role' => $faker->randomElement($roles),
                'nomor_induk' => $faker->unique()->numerify('##########'),
                'nomor_telepon' => $faker->phoneNumber,
                'id_ruangan' => $ruangan->id_ruangan,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'jumlah' => $jumlah,
                'total_harga' => $Totalharga,
                'status' => 'Menunggu',
                'keterangan' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
