<?php

namespace Database\Factories;

use App\Models\Ruangan;
use App\Models\Users;
use Illuminate\Support\Str;
use App\Enums\StatusPeminjaman;
use App\Enums\Penyewa\StatusPenyewa;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Enums\Database\UsersDatabaseColumn;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    public function definition(): array
    {
        $faker = fake('id_ID');

        $user = Users::inRandomOrder()->first() ?? Users::factory()->create();

        // Ambil ruangan acak (kalau belum ada, bikin on-the-fly)
        $ruangan = Ruangan::inRandomOrder()->first() ?? Ruangan::factory()->create([
            UsersDatabaseColumn::IdUsers->value => $user->getKey(),
        ]);

        // Pastikan ruangan memiliki user yang valid
        if (!$ruangan->{UsersDatabaseColumn::IdUsers->value}) {
            $ruangan->{UsersDatabaseColumn::IdUsers->value} = $user->getKey();
            $ruangan->save();
        }

        // Periode pinjam realistis (1–3 hari ke depan)
        $mulai   = Carbon::instance($faker->dateTimeBetween('+0 day', '+3 days'));
        $selesai = (clone $mulai)->addDays($faker->numberBetween(1, 3));

        // Jumlah seat/kuota
        $jumlah = $faker->numberBetween(1, 10);

        // Hitung total_harga sederhana: harga_ruangan * jumlah (sesuaikan logikamu kalau Halfday/Hari/Bulan)
        $hargaSatuan  = (int) $ruangan->{RuanganDatabaseColumn::HargaRuangan->value};
        $totalHarga   = (string) ($hargaSatuan * $jumlah);

        // Placeholder media dokumen
        $placeholder = 'https://picsum.photos/seed/'.Str::random(8).'/600/400';

        // Nomor invoice INV-YYYYMMDD-XXXX
        $invoice = 'INV-'. now()->format('Ymd') .'-'. str_pad((string) $faker->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT);

        return [
            'id_peminjaman'  => (string) Str::uuid(),
            'nama_peminjam'  => $faker->name(),
            'role'           => $faker->randomElement(StatusPenyewa::cases())->value,
            'nomor_induk'    => (string) $faker->numerify('##########'),
            'nomor_telepon'  => $faker->phoneNumber(),

            'ktp_url'        => $placeholder,
            'ktp_public_id'  => 'ktp_'.Str::random(10),
            'ktp_format'     => 'jpg',

            'ktm_url'        => $placeholder,
            'ktm_public_id'  => 'ktm_'.Str::random(10),
            'ktm_format'     => 'jpg',

            'npwp_url'       => $placeholder,
            'npwp_public_id' => 'npwp_'.Str::random(10),
            'npwp_format'    => 'jpg',

            'tanggal_mulai'   => $mulai->format('Y-m-d H:i:s'),
            'tanggal_selesai' => $selesai->format('Y-m-d H:i:s'),

            'jumlah'       => $jumlah,
            'total_harga'  => $totalHarga,

            'status'       => $faker->randomElement(StatusPeminjaman::cases())->value,
            'keterangan'   => $faker->sentence(),

            UsersDatabaseColumn::IdUsers->value => $user->getKey(),
            RuanganDatabaseColumn::IdRuangan->value => $ruangan->getKey(),

            'invoice_number' => $invoice,

            'created_at'   => now(),
            'updated_at'   => now(),
        ];
    }
}
