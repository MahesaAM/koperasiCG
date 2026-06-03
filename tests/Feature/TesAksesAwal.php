<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TesAksesAwal extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function pengunjung_diarahkan_ke_halaman_masuk(): void
    {
        $tanggapan = $this->get('/');

        $tanggapan->assertRedirect('/login');
    }

    #[Test]
    public function pengguna_dapat_masuk_dengan_kata_sandi_indonesia(): void
    {
        $pengguna = Pengguna::create([
            'nama' => 'Administrator',
            'email' => 'admin@example.com',
            'kata_sandi' => 'password',
            'peran' => 'admin',
        ]);

        $tanggapan = $this->post('/masuk', [
            'email' => 'admin@example.com',
            'kata_sandi' => 'password',
        ]);

        $tanggapan->assertRedirect('/');
        $this->assertAuthenticatedAs($pengguna);
    }
}
