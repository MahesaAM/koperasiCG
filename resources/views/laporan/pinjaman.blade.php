@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Laporan Pinjaman</h1>
            <p>Daftar pengajuan pinjaman dalam periode terpilih.</p>
        </div>
        <button onclick="window.print()" class="tombol tombol-sekunder">Cetak</button>
    </div>

    @include('laporan.formulir_tanggal', ['rute' => route('laporan.pinjaman')])

    <div class="pembungkus-tabel">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Anggota</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($daftarPinjaman as $pinjaman)
                    <tr>
                        <td>{{ $pinjaman->tanggal_pengajuan }}</td>
                        <td class="font-semibold text-zinc-950">{{ $pinjaman->anggota->nama }}</td>
                        <td class="font-semibold">Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }}</td>
                        <td><span class="badge badge-{{ $pinjaman->status }}">{{ ucfirst($pinjaman->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="baris-kosong">Tidak ada pinjaman pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
