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
            'username' => '1234',
            'password' => '1234',
        ]);

        $pegawai = Pegawai::factory()->create([
            'user_id' => $user->id,
            'nip' => '1234',
            'nama' => 'Admin',
        ]);
        $user->assignRole('admin');
    }

    private function createPegawai()
    {
        $user = User::factory()->create([
            'username' => '5678',
            'password' => '5678',
        ]);

        $pegawai = Pegawai::factory()->create([
            'user_id' => $user->id,
            'nip' => '5678',
            'nama' => 'Pegawai',
        ]);
        $user->assignRole('pegawai');
    }
}
