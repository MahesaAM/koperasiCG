<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Manager
        \App\Models\User::factory()->create([
            'name' => 'Manager Koperasi',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
            'role' => 'manager',
        ]);

        // Kasir
        \App\Models\User::factory()->create([
            'name' => 'Kasir',
            'email' => 'kasir@example.com',
            'password' => bcrypt('password'),
            'role' => 'kasir',
        ]);
        
        // Administrasi (User logic map to admin or separate role? Prompt said Administrasi. I used admin/manager/kasir/member. Let's add 'administrasi' or assume admin/manager covers it. Prompt: "Administrator/Manajer, Administrasi, dan Kasir". Let's stick to simple roles for now, Administration might be part of Admin or Manager.)
    }
}
