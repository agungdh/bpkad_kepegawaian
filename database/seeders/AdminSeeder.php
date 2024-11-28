<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Honorer;
use App\Models\Pegawai;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $this->seedAdminFromHonorer();
    $this->seedAdminFromPegawai();
    }

    private function seedAdminFromPegawai() {
        $honorer = Honorer::factory()->create();
        $user = $honorer->user;

        $user->username = 'admin';
        $user->role = 'admin';
        $user->password = 'admin';

        $user->save();
    }

    private function seedAdminFromHonorer() {
        $pegawai = Pegawai::factory()->create();
        $user = $pegawai->user;

        $user->username = 'admin2';
        $user->role = 'admin';
        $user->password = 'admin';

        $user->save();
    }
}
