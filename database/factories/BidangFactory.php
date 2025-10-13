<?php

namespace Database\Factories;

use App\Models\Skpd;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bidang>
 */
class BidangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'skpd_id' => Skpd::query()->inRandomOrder()->first()->id,
            'bidang' => fake()->name(),
        ];
    }
}
