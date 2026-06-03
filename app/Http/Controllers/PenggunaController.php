<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function daftar()
    {
        $daftarPengguna = Pengguna::latest()->paginate(10);

        return view('pengguna.daftar', compact('daftarPengguna'));
    }

    public function tambah()
    {
        return view('pengguna.tambah');
    }

    public function simpan(Request $permintaan)
    {
        $tervalidasi = $permintaan->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'kata_sandi' => 'required|string|min:8|confirmed',
            'peran' => 'required|in:admin,manajer,kasir,anggota',
        ]);

        Pengguna::create($tervalidasi);

        return redirect()->route('pengguna.daftar')->with('success', 'Pengguna berhasil dibuat.');
    }

    public function ubah(string $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        return view('pengguna.ubah', compact('pengguna'));
    }

    public function perbarui(Request $permintaan, string $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        $tervalidasi = $permintaan->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,'.$pengguna->id,
            'peran' => 'required|in:admin,manajer,kasir,anggota',
        ]);

        if ($permintaan->filled('kata_sandi')) {
            $permintaan->validate([
                'kata_sandi' => 'required|string|min:8|confirmed',
            ]);
            $tervalidasi['kata_sandi'] = $permintaan->kata_sandi;
        }

        $pengguna->update($tervalidasi);

        return redirect()->route('pengguna.daftar')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function hapus(string $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        if ($pengguna->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $pengguna->delete();

        return redirect()->route('pengguna.daftar')->with('success', 'Pengguna berhasil dihapus.');
    }
}
