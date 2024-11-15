<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create()->each(function($user) {
            $user->assignRole('pegawai');
        });

        User::factory()->create([
            'name' => 'Test User Admin',
            'username' => 'admin',
            'password' => 'admin',
        ])->assignRole('admin');

        User::factory()->create([
            'name' => 'Test User pegawai',
            'username' => 'pegawai',
            'password' => 'pegawai',
        ])->assignRole('pegawai');
    }
}
