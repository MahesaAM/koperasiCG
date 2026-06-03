<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BlackboxAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengguna_bisa_login_dengan_kredensial_benar()
    {
        $pengguna = Pengguna::create([
            'nama' => 'Test User',
            'email' => 'test@koperasi.com',
            'kata_sandi' => Hash::make('password123'),
            'peran' => 'anggota',
        ]);

        $response = $this->post('/masuk', [
            'email' => 'test@koperasi.com',
            'kata_sandi' => 'password123',
        ]);

        $this->assertAuthenticatedAs($pengguna);
        $response->assertRedirect('/');
    }

    public function test_pengguna_tidak_bisa_login_dengan_password_salah()
    {
        Pengguna::create([
            'nama' => 'Test User',
            'email' => 'test@koperasi.com',
            'kata_sandi' => Hash::make('password123'),
            'peran' => 'anggota',
        ]);

        $response = $this->post('/masuk', [
            'email' => 'test@koperasi.com',
            'kata_sandi' => 'salah123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['email']);
    }

    public function test_akses_halaman_internal_tanpa_login_akan_dialihkan()
    {
        $response = $this->get('/');
        
        $response->assertRedirect('/login');
    }
}
