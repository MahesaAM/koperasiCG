@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Laporan Angsuran</h1>
            <p>Rekap pembayaran pinjaman dan pendapatan bunga.</p>
        </div>
        <button onclick="window.print()" class="tombol tombol-sekunder">Cetak</button>
    </div>

    @include('laporan.formulir_tanggal', ['rute' => route('laporan.angsuran')])

    <div class="mb-6 grid gap-4 md:grid-cols-2">
        <div class="kartu-ringkas"><div class="label-kecil">Total Dibayar</div><div class="angka-besar">Rp {{ number_format($totalDibayar, 0, ',', '.') }}</div></div>
        <div class="kartu-ringkas"><div class="label-kecil">Total Bunga</div><div class="angka-besar">Rp {{ number_format($totalBunga, 0, ',', '.') }}</div></div>
    </div>

    <div class="pembungkus-tabel">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Anggota</th>
                    <th>Pinjaman</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($daftarAngsuran as $angsuran)
                    <tr>
                        <td>{{ $angsuran->tanggal_bayar }}</td>
                        <td class="font-semibold text-zinc-950">{{ $angsuran->pinjaman->anggota->nama }}</td>
                        <td>#{{ $angsuran->pinjaman_id }}</td>
                        <td class="font-semibold">Rp {{ number_format($angsuran->jumlah_dibayar, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="baris-kosong">Tidak ada angsuran pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
