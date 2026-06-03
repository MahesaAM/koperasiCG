<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Angsuran;
use App\Models\Pinjaman;
use App\Models\Simpanan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function daftar()
    {
        return view('laporan.daftar');
    }

    public function anggota(Request $permintaan)
    {
        $status = $permintaan->query('status');
        $kueri = Anggota::query();

        if ($status) {
            $kueri->where('status', $status);
        }

        $daftarAnggota = $kueri->get();

        return view('laporan.anggota', compact('daftarAnggota', 'status'));
    }

    public function simpanan(Request $permintaan)
    {
        $tanggalMulai = $permintaan->query('tanggal_mulai');
        $tanggalAkhir = $permintaan->query('tanggal_akhir');
        $kueri = Simpanan::with('anggota');

        if ($tanggalMulai && $tanggalAkhir) {
            $kueri->whereBetween('tanggal_transaksi', [$tanggalMulai, $tanggalAkhir]);
        }

        $daftarSimpanan = $kueri->get();
        $totalSetoran = $daftarSimpanan->where('jenis_transaksi', 'setoran')->sum('jumlah');
        $totalPenarikan = $daftarSimpanan->where('jenis_transaksi', 'penarikan')->sum('jumlah');

        return view('laporan.simpanan', compact('daftarSimpanan', 'totalSetoran', 'totalPenarikan', 'tanggalMulai', 'tanggalAkhir'));
    }

    public function pinjaman(Request $permintaan)
    {
        $tanggalMulai = $permintaan->query('tanggal_mulai');
        $tanggalAkhir = $permintaan->query('tanggal_akhir');
        $kueri = Pinjaman::with('anggota');

        if ($tanggalMulai && $tanggalAkhir) {
            $kueri->whereBetween('tanggal_pengajuan', [$tanggalMulai, $tanggalAkhir]);
        }

        $daftarPinjaman = $kueri->get();

        return view('laporan.pinjaman', compact('daftarPinjaman', 'tanggalMulai', 'tanggalAkhir'));
    }

    public function angsuran(Request $permintaan)
    {
        $tanggalMulai = $permintaan->query('tanggal_mulai');
        $tanggalAkhir = $permintaan->query('tanggal_akhir');
        $kueri = Angsuran::with('pinjaman.anggota');

        if ($tanggalMulai && $tanggalAkhir) {
            $kueri->whereBetween('tanggal_bayar', [$tanggalMulai, $tanggalAkhir]);
        }

        $daftarAngsuran = $kueri->get();
        $totalDibayar = $daftarAngsuran->sum('jumlah_dibayar');
        $totalBunga = $daftarAngsuran->sum('bunga_dibayar');

        return view('laporan.angsuran', compact('daftarAngsuran', 'totalDibayar', 'totalBunga', 'tanggalMulai', 'tanggalAkhir'));
    }

    public function keuangan()
    {
        $totalSimpanan = Simpanan::where('jenis_transaksi', 'setoran')->where('status', 'disetujui')->sum('jumlah')
            - Simpanan::where('jenis_transaksi', 'penarikan')->where('status', 'disetujui')->sum('jumlah');

        $totalPinjamanDisalurkan = Pinjaman::whereIn('status', ['disetujui', 'lunas'])->sum('jumlah');
        $totalPokokDibayar = Angsuran::where('status', 'disetujui')->sum('pokok_dibayar');
        $sisaPinjaman = $totalPinjamanDisalurkan - $totalPokokDibayar;
        $totalPendapatanBunga = Angsuran::where('status', 'disetujui')->sum('bunga_dibayar');

        return view('laporan.keuangan', compact('totalSimpanan', 'totalPinjamanDisalurkan', 'sisaPinjaman', 'totalPendapatanBunga'));
    }
}
