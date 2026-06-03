<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Simpanan;
use Illuminate\Http\Request;

class SimpananController extends Controller
{
    public function daftar()
    {
        $kueri = Simpanan::with('anggota');

        if (auth()->user()->peran === 'anggota') {
            if (auth()->user()->anggota) {
                $kueri->where('anggota_id', auth()->user()->anggota->id);
            } else {
                $kueri->where('id', 0);
            }
        }

        $daftarSimpanan = $kueri->latest()->paginate(10);

        return view('simpanan.daftar', compact('daftarSimpanan'));
    }

    public function tambah()
    {
        if (auth()->user()->peran === 'anggota' && auth()->user()->anggota) {
            $daftarAnggota = Anggota::where('id', auth()->user()->anggota->id)->get();
        } else {
            $daftarAnggota = Anggota::where('status', 'aktif')->get();
        }

        return view('simpanan.tambah', compact('daftarAnggota'));
    }

    public function simpan(Request $permintaan)
    {
        $aturan = [
            'anggota_id' => 'required|exists:anggota,id',
            'jenis' => 'required|in:pokok,wajib,sukarela',
            'jenis_transaksi' => 'required|in:setoran,penarikan',
            'jumlah' => 'required|numeric|min:0',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string',
        ];

        if (auth()->user()->peran === 'anggota' && $permintaan->input('jenis_transaksi') === 'setoran') {
            $aturan['berkas_bukti'] = 'required|file|mimes:jpeg,png,pdf|max:2048';
        } else {
            $aturan['berkas_bukti'] = 'nullable|file|mimes:jpeg,png,pdf|max:2048';
        }

        $tervalidasi = $permintaan->validate($aturan);

        if ($tervalidasi['jenis_transaksi'] === 'penarikan') {
            $saldoSaatIni = $this->hitungSaldo($tervalidasi['anggota_id'], $tervalidasi['jenis']);

            if ($tervalidasi['jumlah'] > $saldoSaatIni) {
                return back()->withErrors(['jumlah' => 'Saldo aktif tidak mencukupi untuk penarikan.']);
            }
        }

        $tervalidasi['status'] = auth()->user()->peran === 'anggota' ? 'menunggu' : 'disetujui';

        if ($permintaan->hasFile('berkas_bukti')) {
            $tervalidasi['berkas_bukti'] = $permintaan->file('berkas_bukti')->store('bukti', 'public');
        }

        Simpanan::create($tervalidasi);

        $pesan = auth()->user()->peran === 'anggota'
            ? 'Transaksi berhasil dikirim. Silakan tunggu verifikasi admin.'
            : 'Transaksi berhasil dicatat.';

        return redirect()->route('simpanan.daftar')->with('success', $pesan);
    }

    public function setujui(Request $permintaan, string $id)
    {
        if (! in_array($permintaan->user()->peran, ['admin', 'manajer'])) {
            abort(403);
        }

        $simpanan = Simpanan::findOrFail($id);

        if ($simpanan->status !== 'menunggu') {
            return back()->with('error', 'Transaksi tidak dalam status menunggu.');
        }

        if ($simpanan->jenis_transaksi === 'penarikan') {
            $saldoSaatIni = $this->hitungSaldo($simpanan->anggota_id, $simpanan->jenis);

            if ($simpanan->jumlah > $saldoSaatIni) {
                $simpanan->update(['status' => 'ditolak']);

                return back()->with('error', 'Saldo tidak mencukupi. Transaksi ditolak.');
            }
        }

        $simpanan->update(['status' => 'disetujui']);

        return back()->with('success', 'Transaksi disetujui.');
    }

    public function tolak(Request $permintaan, string $id)
    {
        if (! in_array($permintaan->user()->peran, ['admin', 'manajer'])) {
            abort(403);
        }

        $simpanan = Simpanan::findOrFail($id);
        $simpanan->update(['status' => 'ditolak']);

        return back()->with('success', 'Transaksi ditolak.');
    }

    public function detail(string $id)
    {
        $simpanan = Simpanan::with('anggota')->findOrFail($id);

        if (auth()->user()->peran === 'anggota' && auth()->user()->anggota->id !== $simpanan->anggota_id) {
            abort(403);
        }

        return view('simpanan.detail', compact('simpanan'));
    }

    public function hapus(string $id)
    {
        $simpanan = Simpanan::findOrFail($id);
        $simpanan->delete();

        return redirect()->route('simpanan.daftar')->with('success', 'Transaksi berhasil dihapus.');
    }

    private function hitungSaldo(int $anggotaId, string $jenis): float
    {
        return Simpanan::where('anggota_id', $anggotaId)
            ->where('jenis', $jenis)
            ->where('jenis_transaksi', 'setoran')
            ->where('status', 'disetujui')
            ->sum('jumlah')
            - Simpanan::where('anggota_id', $anggotaId)
                ->where('jenis', $jenis)
                ->where('jenis_transaksi', 'penarikan')
                ->where('status', 'disetujui')
                ->sum('jumlah');
    }
}
