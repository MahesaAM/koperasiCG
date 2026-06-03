<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pinjaman;
use App\Models\Simpanan;

class BerandaController extends Controller
{
    public function tampil()
    {
        $pengguna = auth()->user();

        if ($pengguna->peran === 'anggota') {
            $anggota = $pengguna->anggota;

            if (! $anggota) {
                return view('beranda', [
                    'totalAnggota' => 0,
                    'totalSimpanan' => 0,
                    'pinjamanAktif' => 0,
                    'peringatan' => 'Akun Anda belum terhubung dengan profil anggota.',
                ]);
            }

            $daftarSimpanan = Simpanan::where('anggota_id', $anggota->id)
                ->where('status', 'disetujui')
                ->get();

            $totalAnggota = 1;
            $totalSimpanan = $daftarSimpanan->where('jenis_transaksi', 'setoran')->sum('jumlah')
                - $daftarSimpanan->where('jenis_transaksi', 'penarikan')->sum('jumlah');
            $pinjamanAktif = Pinjaman::where('anggota_id', $anggota->id)
                ->whereIn('status', ['menunggu', 'disetujui'])
                ->count();

            return view('beranda', compact('totalAnggota', 'totalSimpanan', 'pinjamanAktif'));
        }

        $totalAnggota = Anggota::count();
        $totalSimpanan = Simpanan::where('jenis_transaksi', 'setoran')->where('status', 'disetujui')->sum('jumlah')
            - Simpanan::where('jenis_transaksi', 'penarikan')->where('status', 'disetujui')->sum('jumlah');
        $pinjamanAktif = Pinjaman::where('status', 'disetujui')->count();

        return view('beranda', compact('totalAnggota', 'totalSimpanan', 'pinjamanAktif'));
    }
}
