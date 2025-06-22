<?php

namespace Database\Factories;

use App\Models\Gambar;
use App\Enums\Database\RuanganDatabaseColumn;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gambar>
 */
class GambarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Gambar::class;

    public function definition(): array
    {
        return [
            RuanganDatabaseColumn::IdRuangan->value => null, // nanti diisi setelah Ruangan dibuat
            'url' => "",
        ];
    }
}
