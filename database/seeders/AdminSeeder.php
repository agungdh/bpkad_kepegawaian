<?php

namespace Database\Seeders;

use App\Models\Honorer;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;

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

    private function seedAdminFromPegawai()
    {
        $honorer = Honorer::factory()->create(['nama' => 'Admin']);
        $user = $honorer->user;

        $user->username = 'admin';
        $user->role = 'admin';
        $user->password = 'admin';

        $user->save();
    }

    private function seedAdminFromHonorer()
    {
        $pegawai = Pegawai::factory()->create(['nama' => 'Admin 2']);
        $user = $pegawai->user;

        $user->username = 'admin2';
        $user->role = 'admin';
        $user->password = 'admin';

        $user->save();
    }
}
