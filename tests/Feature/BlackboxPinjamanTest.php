<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use App\Models\Anggota;
use App\Models\Pengaturan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BlackboxPinjamanTest extends TestCase
{
    use RefreshDatabase;

    public function test_anggota_mengajukan_pinjaman_bunga_dipaksa_ke_default()
    {
        // 1. Setup Admin dan Pengaturan Bunga
        $admin = Pengguna::create([
            'nama' => 'Admin', 'email' => 'admin@koperasi.com',
            'kata_sandi' => Hash::make('password'), 'peran' => 'admin'
        ]);
        
        Pengaturan::create([
            'kunci' => 'persentase_bunga_bawaan',
            'nilai' => '7.50'
        ]);

        // 2. Setup Anggota
        $akunAnggota = Pengguna::create([
            'nama' => 'User Anggota', 'email' => 'anggota@koperasi.com',
            'kata_sandi' => Hash::make('password'), 'peran' => 'anggota'
        ]);
        
        $profilAnggota = Anggota::create([
            'pengguna_id' => $akunAnggota->id,
            'nik' => '1234567890',
            'nama' => 'User Anggota',
            'alamat' => 'Alamat',
            'telepon' => '08123',
            'tanggal_bergabung' => '2023-01-01',
            'status' => 'aktif'
        ]);

        // 3. Eksekusi: Anggota mencoba mengajukan pinjaman dengan bunga curang (0%)
        $response = $this->actingAs($akunAnggota)->post('/pinjaman', [
            'anggota_id' => $profilAnggota->id,
            'jumlah' => 1000000,
            'persentase_bunga' => 0.00, // Coba memanipulasi form yang readonly
            'durasi_bulan' => 12,
            'tanggal_pengajuan' => '2026-06-04'
        ]);

        // 4. Verifikasi (Assert)
        $response->assertRedirect('/pinjaman');
        $this->assertDatabaseHas('pinjaman', [
            'anggota_id' => $profilAnggota->id,
            'jumlah' => 1000000,
            'persentase_bunga' => '7.50', // Harus dipaksa menggunakan nilai admin
            'status' => 'menunggu'
        ]);
    }
}
