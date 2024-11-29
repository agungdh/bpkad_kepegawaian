<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Honorer>
 */
class HonorerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nik = fake()->nik;

        $user = User::factory(['username' => $nik])->create();

        return [
            'user_id' => $user->id,
            'nik' => $nik,
            'nama' => fake()->name(),
        ];
    }
}
