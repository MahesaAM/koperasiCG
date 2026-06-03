<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pengaturan;
use App\Models\Pinjaman;
use Illuminate\Http\Request;

class PinjamanController extends Controller
{
    public function daftar()
    {
        $kueri = Pinjaman::with('anggota');

        if (auth()->user()->peran === 'anggota') {
            if (auth()->user()->anggota) {
                $kueri->where('anggota_id', auth()->user()->anggota->id);
            } else {
                $kueri->where('id', 0);
            }
        }

        $daftarPinjaman = $kueri->latest()->paginate(10);
        $persentaseBungaBawaan = Pengaturan::where('kunci', 'persentase_bunga_bawaan')->value('nilai') ?? '5.00';

        return view('pinjaman.daftar', compact('daftarPinjaman', 'persentaseBungaBawaan'));
    }

    public function perbaruiBunga(Request $permintaan)
    {
        if (! in_array(auth()->user()->peran, ['admin', 'manajer'])) {
            abort(403);
        }

        $tervalidasi = $permintaan->validate([
            'persentase_bunga_bawaan' => 'required|numeric|min:0',
        ]);

        Pengaturan::updateOrCreate(
            ['kunci' => 'persentase_bunga_bawaan'],
            ['nilai' => $tervalidasi['persentase_bunga_bawaan']]
        );

        return back()->with('success', 'Bunga koperasi berhasil diperbarui.');
    }

    public function tambah()
    {
        $daftarAnggota = Anggota::where('status', 'aktif')->get();
        $persentaseBungaBawaan = Pengaturan::where('kunci', 'persentase_bunga_bawaan')->value('nilai') ?? '5.00';

        return view('pinjaman.tambah', compact('daftarAnggota', 'persentaseBungaBawaan'));
    }

    public function simpan(Request $permintaan)
    {
        $tervalidasi = $permintaan->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'jumlah' => 'required|numeric|min:0',
            'persentase_bunga' => 'required|numeric|min:0',
            'durasi_bulan' => 'required|integer|min:1',
            'tanggal_pengajuan' => 'required|date',
        ]);

        $tervalidasi['status'] = 'menunggu';

        if (auth()->user()->peran === 'anggota') {
            $tervalidasi['persentase_bunga'] = Pengaturan::where('kunci', 'persentase_bunga_bawaan')->value('nilai') ?? '5.00';
        }

        Pinjaman::create($tervalidasi);

        return redirect()->route('pinjaman.daftar')->with('success', 'Pengajuan pinjaman berhasil dikirim.');
    }

    public function detail(string $id)
    {
        $pinjaman = Pinjaman::with(['anggota', 'angsuran', 'penyetuju'])->findOrFail($id);

        return view('pinjaman.detail', compact('pinjaman'));
    }

    public function ubah(string $id)
    {
        $pinjaman = Pinjaman::findOrFail($id);

        if ($pinjaman->status !== 'menunggu') {
            return back()->with('error', 'Hanya pinjaman berstatus menunggu yang dapat diubah.');
        }

        $daftarAnggota = Anggota::where('status', 'aktif')->get();
        $persentaseBungaBawaan = Pengaturan::where('kunci', 'persentase_bunga_bawaan')->value('nilai') ?? '5.00';

        return view('pinjaman.ubah', compact('pinjaman', 'daftarAnggota', 'persentaseBungaBawaan'));
    }

    public function perbarui(Request $permintaan, string $id)
    {
        $pinjaman = Pinjaman::findOrFail($id);

        if ($pinjaman->status !== 'menunggu') {
            return back()->with('error', 'Hanya pinjaman berstatus menunggu yang dapat diubah.');
        }

        $tervalidasi = $permintaan->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'jumlah' => 'required|numeric|min:0',
            'persentase_bunga' => 'required|numeric|min:0',
            'durasi_bulan' => 'required|integer|min:1',
            'tanggal_pengajuan' => 'required|date',
        ]);

        $pinjaman->update($tervalidasi);

        return redirect()->route('pinjaman.daftar')->with('success', 'Pinjaman berhasil diperbarui.');
    }

    public function hapus(string $id)
    {
        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->delete();

        return redirect()->route('pinjaman.daftar')->with('success', 'Pinjaman berhasil dihapus.');
    }

    public function setujui(Request $permintaan, string $id)
    {
        if (! in_array($permintaan->user()->peran, ['admin', 'manajer'])) {
            abort(403);
        }

        $pinjaman = Pinjaman::findOrFail($id);

        if ($pinjaman->status !== 'menunggu') {
            return back()->with('error', 'Pinjaman tidak dalam status menunggu persetujuan.');
        }

        $pinjaman->update([
            'status' => 'disetujui',
            'disetujui_oleh' => $permintaan->user()->id,
            'tanggal_persetujuan' => now(),
        ]);

        return back()->with('success', 'Pinjaman berhasil disetujui.');
    }

    public function tolak(Request $permintaan, string $id)
    {
        if (! in_array($permintaan->user()->peran, ['admin', 'manajer'])) {
            abort(403);
        }

        $pinjaman = Pinjaman::findOrFail($id);

        if ($pinjaman->status !== 'menunggu') {
            return back()->with('error', 'Pinjaman tidak dalam status menunggu persetujuan.');
        }

        $pinjaman->update([
            'status' => 'ditolak',
            'disetujui_oleh' => $permintaan->user()->id,
            'tanggal_persetujuan' => now(),
        ]);

        return back()->with('success', 'Pinjaman ditolak.');
    }
}
