<?php

namespace Database\Factories;

use App\Models\Ruangan;
use App\Enums\StatusRuangan;
use App\Models\Users;
use App\Enums\Database\UsersDatabaseColumn;
use App\Enums\Penyewa\SatuanPenyewa;
use App\Enums\Database\RuanganDatabaseColumn;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ruangan>
 */
class RuanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Ruangan::class;

    public function definition(): array
    {
        $user = Users::inRandomOrder()->first() ?? Users::factory()->create();

        return [
            RuanganDatabaseColumn::GroupIdRuangan->value => $this->faker->uuid(),
            RuanganDatabaseColumn::NamaRuangan->value => $this->faker->words(2, true),
            RuanganDatabaseColumn::KapasitasMinimal->value => $this->faker->numberBetween(2, 8),
            RuanganDatabaseColumn::KapasitasMaksimal->value => $this->faker->numberBetween(10, 50),
            RuanganDatabaseColumn::SatuanPenyewaanRuangan->value => $this->faker->randomElement([SatuanPenyewa::SeatPerBulan->value, SatuanPenyewa::SeatPerHari->value, SatuanPenyewa::Halfday->value]),
            RuanganDatabaseColumn::LokasiRuangan->value => $this->faker->randomElement(['Gedung A', 'Gedung B', 'Gedung C', 'Gedung D']),
            RuanganDatabaseColumn::HargaRuangan->value => $this->faker->numberBetween(50000, 1000000),
            RuanganDatabaseColumn::StatusRuangan->value => $this->faker->randomElement([StatusRuangan::Penuh->value, StatusRuangan::Tersedia->value, StatusRuangan::Digunakan->value]),
            RuanganDatabaseColumn::KeteranganRuangan->value => $this->faker->sentence(4),
            // pastikan ruangan terhubung ke user yang valid
            UsersDatabaseColumn::IdUsers->value => $user->getKey(),
        ];
    }
}
