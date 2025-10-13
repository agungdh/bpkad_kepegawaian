<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdmin();
        $this->createPegawai();

        Pegawai::factory(100)->create()->each(function ($pegawai) {
            $user = $pegawai->user;
            $user->assignRole('pegawai');
        });
    }

    private function createAdmin()
    {
        $user = User::factory()->create([
            'username' => 'admin',
        ]);

        $pegawai = Pegawai::factory()->create([
            'user_id' => $user->id,
            'nip' => 'admin',
            'nama' => 'Admin',
        ]);
        $user->assignRole('admin');
    }

    private function createPegawai()
    {
        $user = User::factory()->create([
            'username' => 'pegawai',
        ]);

        $pegawai = Pegawai::factory()->create([
            'user_id' => $user->id,
            'nip' => 'pegawai',
            'nama' => 'Pegawai',
        ]);
        $user->assignRole('pegawai');
    }
}
