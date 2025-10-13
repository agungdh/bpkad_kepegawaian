<?php

namespace Database\Factories;

use App\Models\Bidang;
use App\Models\Skpd;
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
        $nip = fake()->nik();

        $user = User::factory()->create([
            'username' => $nip,
        ]);
        $bidang = Bidang::query()->inRandomOrder()->first();
        $skpd = $bidang->skpd;

        return [
            'user_id' => $user->id,
            'skpd_id' => $skpd->id,
            'bidang_id' => $bidang->id,
            'nama' => fake()->name(),
            'nip' => $nip,
        ];
    }
}
