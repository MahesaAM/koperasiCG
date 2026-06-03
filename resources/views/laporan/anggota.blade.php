@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Laporan Anggota</h1>
            <p>Filter anggota berdasarkan status keanggotaan.</p>
        </div>
        <button onclick="window.print()" class="tombol tombol-sekunder">Cetak</button>
    </div>

    <form action="{{ route('laporan.anggota') }}" method="GET" class="mb-6 flex flex-wrap items-end gap-3 rounded-lg border border-zinc-200 bg-white p-4 shadow-sm">
        <div>
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-input">
                <option value="">Semua</option>
                <option value="aktif" @selected($status === 'aktif')>Aktif</option>
                <option value="tidak_aktif" @selected($status === 'tidak_aktif')>Tidak Aktif</option>
            </select>
        </div>
        <button class="tombol tombol-primer">Tampilkan</button>
    </form>

    <div class="pembungkus-tabel">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($daftarAnggota as $anggota)
                    <tr>
                        <td class="font-mono text-xs">{{ $anggota->nik }}</td>
                        <td class="font-semibold text-zinc-950">{{ $anggota->nama }}</td>
                        <td>{{ $anggota->telepon }}</td>
                        <td><span class="badge {{ $anggota->status === 'aktif' ? 'badge-aktif' : 'badge-tidak-aktif' }}">{{ $anggota->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="baris-kosong">Tidak ada data anggota.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
