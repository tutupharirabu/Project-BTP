<?php

namespace Database\Factories;

use App\Enums\Admin\RoleAdmin;
use App\Enums\Database\UsersDatabaseColumn;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = $this->faker;

        return [
            UsersDatabaseColumn::Username->value    => $faker->userName(),
            UsersDatabaseColumn::Email->value       => $faker->unique()->safeEmail(),
            UsersDatabaseColumn::Role->value        => $faker->randomElement([
                RoleAdmin::Admin->value,
                RoleAdmin::Petugas->value,
            ]),
            UsersDatabaseColumn::NamaLengkap->value => $faker->name(),
            UsersDatabaseColumn::Password->value    => 'password',
        ];
    }

}
