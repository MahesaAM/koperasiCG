@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Laporan Simpanan</h1>
            <p>Rekap setoran, penarikan, dan saldo pada periode tertentu.</p>
        </div>
        <button onclick="window.print()" class="tombol tombol-sekunder">Cetak</button>
    </div>

    @include('laporan.formulir_tanggal', ['rute' => route('laporan.simpanan')])

    <div class="mb-6 grid gap-4 md:grid-cols-3">
        <div class="kartu-ringkas"><div class="label-kecil">Total Setoran</div><div class="angka-besar">Rp {{ number_format($totalSetoran, 0, ',', '.') }}</div></div>
        <div class="kartu-ringkas"><div class="label-kecil">Total Penarikan</div><div class="angka-besar">Rp {{ number_format($totalPenarikan, 0, ',', '.') }}</div></div>
        <div class="kartu-ringkas"><div class="label-kecil">Saldo</div><div class="angka-besar">Rp {{ number_format($totalSetoran - $totalPenarikan, 0, ',', '.') }}</div></div>
    </div>

    <div class="pembungkus-tabel">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Anggota</th>
                    <th>Jenis</th>
                    <th>Transaksi</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($daftarSimpanan as $simpanan)
                    <tr>
                        <td>{{ $simpanan->tanggal_transaksi }}</td>
                        <td class="font-semibold text-zinc-950">{{ $simpanan->anggota->nama }}</td>
                        <td>{{ ucfirst($simpanan->jenis) }}</td>
                        <td>{{ $simpanan->jenis_transaksi === 'setoran' ? 'Setoran' : 'Penarikan' }}</td>
                        <td class="font-semibold">Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="baris-kosong">Tidak ada transaksi pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
