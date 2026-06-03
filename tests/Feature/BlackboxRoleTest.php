<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BlackboxRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_anggota_tidak_bisa_mengakses_halaman_admin()
    {
        $anggota = Pengguna::create([
            'nama' => 'Anggota Biasa',
            'email' => 'anggota@koperasi.com',
            'kata_sandi' => Hash::make('password123'),
            'peran' => 'anggota',
        ]);

        $response = $this->actingAs($anggota)->get('/pengguna');

        $response->assertStatus(403);
    }
    
    public function test_admin_bisa_mengakses_halaman_admin()
    {
        $admin = Pengguna::create([
            'nama' => 'Admin Sistem',
            'email' => 'admin@koperasi.com',
            'kata_sandi' => Hash::make('password123'),
            'peran' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/pengguna');

        $response->assertStatus(200);
    }
}
