<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (isset($this->username)) {
            dd($this->username);

        }
        $nik = fake()->nik;

        $user = User::factory(['username' => $nik])->create();

        return [
            'user_id' => $user->id,
            'nip' => $nik,
            'nama' => fake()->name(),
        ];
    }
}
