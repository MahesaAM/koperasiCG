<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Pengguna::factory()->create([
            'nama' => 'Administrator',
            'email' => 'admin@example.com',
            'kata_sandi' => 'password',
            'peran' => 'admin',
        ]);

        Pengguna::factory()->create([
            'nama' => 'Manajer Koperasi',
            'email' => 'manajer@example.com',
            'kata_sandi' => 'password',
            'peran' => 'manajer',
        ]);

        Pengguna::factory()->create([
            'nama' => 'Kasir',
            'email' => 'kasir@example.com',
            'kata_sandi' => 'password',
            'peran' => 'kasir',
        ]);
    }
}
