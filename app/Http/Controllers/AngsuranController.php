<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\Pinjaman;
use Illuminate\Http\Request;

class AngsuranController extends Controller
{
    public function daftar()
    {
        $kueri = Angsuran::with('pinjaman.anggota');

        if (auth()->user()->peran === 'anggota') {
            if (auth()->user()->anggota) {
                $kueri->whereHas('pinjaman', function ($subKueri) {
                    $subKueri->where('anggota_id', auth()->user()->anggota->id);
                });
            } else {
                $kueri->where('id', 0);
            }
        }

        $daftarAngsuran = $kueri->latest()->paginate(10);

        return view('angsuran.daftar', compact('daftarAngsuran'));
    }

    public function tambah(Request $permintaan)
    {
        $pinjamanId = $permintaan->query('pinjaman_id');
        $pinjaman = null;

        if ($pinjamanId) {
            $pinjaman = Pinjaman::with('anggota')->find($pinjamanId);

            if (auth()->user()->peran === 'anggota' && auth()->user()->anggota) {
                if (! $pinjaman || $pinjaman->anggota_id !== auth()->user()->anggota->id) {
                    abort(403, 'Akses pinjaman tidak diizinkan.');
                }
            }
        }

        $kueri = Pinjaman::where('status', 'disetujui')->with('anggota');

        if (auth()->user()->peran === 'anggota' && auth()->user()->anggota) {
            $kueri->where('anggota_id', auth()->user()->anggota->id);
        }

        $daftarPinjaman = $kueri->get();

        return view('angsuran.tambah', compact('pinjaman', 'daftarPinjaman'));
    }

    public function simpan(Request $permintaan)
    {
        $tervalidasi = $permintaan->validate([
            'pinjaman_id' => 'required|exists:pinjaman,id',
            'tanggal_bayar' => 'required|date',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
            'berkas_bukti' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        $pinjaman = Pinjaman::find($tervalidasi['pinjaman_id']);

        if (auth()->user()->peran === 'anggota') {
            if (! $pinjaman || ! auth()->user()->anggota || $pinjaman->anggota_id !== auth()->user()->anggota->id) {
                abort(403, 'Anda hanya dapat membayar angsuran untuk pinjaman Anda sendiri.');
            }
        }

        $totalPokok = $pinjaman->jumlah;
        $totalBunga = $totalPokok * ($pinjaman->persentase_bunga / 100);
        $totalTagihan = $totalPokok + $totalBunga;
        $rasioBunga = $totalTagihan > 0 ? ($totalBunga / $totalTagihan) : 0;

        $tervalidasi['bunga_dibayar'] = $tervalidasi['jumlah_dibayar'] * $rasioBunga;
        $tervalidasi['pokok_dibayar'] = $tervalidasi['jumlah_dibayar'] - $tervalidasi['bunga_dibayar'];
        $tervalidasi['status'] = auth()->user()->peran === 'anggota' ? 'menunggu' : 'disetujui';

        if ($permintaan->hasFile('berkas_bukti')) {
            $tervalidasi['berkas_bukti'] = $permintaan->file('berkas_bukti')->store('bukti', 'public');
        }

        Angsuran::create($tervalidasi);

        if ($tervalidasi['status'] === 'disetujui') {
            $this->perbaruiStatusPinjaman($pinjaman);
        }

        $pesan = auth()->user()->peran === 'anggota'
            ? 'Pembayaran berhasil dicatat. Silakan tunggu verifikasi admin.'
            : 'Pembayaran berhasil dicatat.';

        return redirect()->route('angsuran.daftar')->with('success', $pesan);
    }

    public function setujui(Request $permintaan, string $id)
    {
        if (! in_array($permintaan->user()->peran, ['admin', 'manajer'])) {
            abort(403);
        }

        $angsuran = Angsuran::findOrFail($id);

        if ($angsuran->status !== 'menunggu') {
            return back()->with('error', 'Pembayaran tidak dalam status menunggu.');
        }

        $angsuran->update(['status' => 'disetujui']);
        $this->perbaruiStatusPinjaman($angsuran->pinjaman);

        return back()->with('success', 'Pembayaran disetujui.');
    }

    public function tolak(Request $permintaan, string $id)
    {
        if (! in_array($permintaan->user()->peran, ['admin', 'manajer'])) {
            abort(403);
        }

        $angsuran = Angsuran::findOrFail($id);
        $angsuran->update(['status' => 'ditolak']);

        return back()->with('success', 'Pembayaran ditolak.');
    }

    public function detail(string $id)
    {
        $angsuran = Angsuran::with('pinjaman.anggota')->findOrFail($id);

        if (auth()->user()->peran === 'anggota' && auth()->user()->anggota->id !== $angsuran->pinjaman->anggota_id) {
            abort(403);
        }

        return view('angsuran.detail', compact('angsuran'));
    }

    public function hapus(string $id)
    {
        $angsuran = Angsuran::findOrFail($id);
        $angsuran->delete();

        return back()->with('success', 'Angsuran berhasil dihapus.');
    }

    private function perbaruiStatusPinjaman(Pinjaman $pinjaman): void
    {
        $totalPokok = $pinjaman->jumlah;
        $totalBunga = $totalPokok * ($pinjaman->persentase_bunga / 100);
        $totalTagihan = $totalPokok + $totalBunga;
        $totalDibayar = $pinjaman->angsuran()->where('status', 'disetujui')->sum('jumlah_dibayar');

        if ($totalDibayar >= ($totalTagihan - 100)) {
            $pinjaman->update(['status' => 'lunas']);
        }
    }
}
