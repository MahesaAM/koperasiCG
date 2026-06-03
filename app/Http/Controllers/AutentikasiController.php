<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutentikasiController extends Controller
{
    public function formulirMasuk()
    {
        return view('autentikasi.masuk');
    }

    public function masuk(Request $permintaan)
    {
        $tervalidasi = $permintaan->validate([
            'email' => ['required', 'email'],
            'kata_sandi' => ['required'],
        ]);

        $berhasil = Auth::attempt([
            'email' => $tervalidasi['email'],
            'password' => $tervalidasi['kata_sandi'],
        ]);

        if ($berhasil) {
            $permintaan->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak sesuai.',
        ])->onlyInput('email');
    }

    public function formulirDaftar()
    {
        return view('autentikasi.daftar');
    }

    public function daftar(Request $permintaan)
    {
        $tervalidasi = $permintaan->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna,email',
            'kata_sandi' => 'required|string|min:8|confirmed',
            'nik' => 'required|string|unique:anggota,nik',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
        ]);

        $pengguna = Pengguna::create([
            'nama' => $tervalidasi['nama'],
            'email' => $tervalidasi['email'],
            'kata_sandi' => $tervalidasi['kata_sandi'],
            'peran' => 'anggota',
        ]);

        Anggota::create([
            'pengguna_id' => $pengguna->id,
            'nik' => $tervalidasi['nik'],
            'nama' => $tervalidasi['nama'],
            'alamat' => $tervalidasi['alamat'],
            'telepon' => $tervalidasi['telepon'],
            'tanggal_bergabung' => now(),
            'status' => 'tidak_aktif',
        ]);

        Auth::login($pengguna);

        return redirect('/')->with('success', 'Pendaftaran berhasil. Silakan tunggu verifikasi admin.');
    }

    public function keluar(Request $permintaan)
    {
        Auth::logout();
        $permintaan->session()->invalidate();
        $permintaan->session()->regenerateToken();

        return redirect('/masuk');
    }
}
