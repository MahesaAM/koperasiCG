<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnggotaController extends Controller
{
    public function daftar()
    {
        $daftarAnggota = Anggota::with('pengguna')->latest()->paginate(10);

        return view('anggota.daftar', compact('daftarAnggota'));
    }

    public function tambah()
    {
        return view('anggota.tambah');
    }

    public function simpan(Request $permintaan)
    {
        $tervalidasi = $permintaan->validate([
            'nik' => 'required|unique:anggota,nik',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:30',
            'tanggal_bergabung' => 'required|date',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        Anggota::create($tervalidasi);

        return redirect()->route('anggota.daftar')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function detail(string $id)
    {
        $anggota = Anggota::with('pengguna')->findOrFail($id);

        return view('anggota.detail', compact('anggota'));
    }

    public function ubah(string $id)
    {
        $anggota = Anggota::findOrFail($id);

        return view('anggota.ubah', compact('anggota'));
    }

    public function perbarui(Request $permintaan, string $id)
    {
        $anggota = Anggota::findOrFail($id);

        $tervalidasi = $permintaan->validate([
            'nik' => 'required|unique:anggota,nik,'.$anggota->id,
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:30',
            'tanggal_bergabung' => 'required|date',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $anggota->update($tervalidasi);

        return redirect()->route('anggota.daftar')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function hapus(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('anggota.daftar')->with('success', 'Anggota berhasil dihapus.');
    }

    public function buatAkun(Request $permintaan, string $id)
    {
        $anggota = Anggota::findOrFail($id);

        if ($anggota->pengguna_id) {
            return back()->with('error', 'Anggota sudah memiliki akun pengguna.');
        }

        $kataSandiAwal = 'password';
        $email = Str::slug($anggota->nama, '.').'@example.com';

        $pengguna = Pengguna::create([
            'nama' => $anggota->nama,
            'email' => $email,
            'kata_sandi' => $kataSandiAwal,
            'peran' => 'anggota',
        ]);

        $anggota->update(['pengguna_id' => $pengguna->id]);

        return back()->with('success', 'Akun pengguna berhasil dibuat. Email: '.$pengguna->email.', kata sandi: '.$kataSandiAwal);
    }
}
