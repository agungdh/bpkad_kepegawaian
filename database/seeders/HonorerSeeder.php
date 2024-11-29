<?php

namespace Database\Seeders;

use App\Models\Honorer;
use Illuminate\Database\Seeder;

class HonorerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Honorer::factory(100)->create();
    }
}
