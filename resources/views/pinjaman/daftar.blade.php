@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Pinjaman</h1>
            <p>Kelola pengajuan, persetujuan, dan status pelunasan pinjaman anggota.</p>
        </div>
        <a href="{{ route('pinjaman.tambah') }}" class="tombol tombol-primer">Ajukan Pinjaman</a>
    </div>

    @if(in_array(auth()->user()->peran, ['admin', 'manajer']))
        <form action="{{ route('pinjaman.pengaturan.bunga') }}" method="POST" class="mb-6 flex flex-wrap items-end gap-3 rounded-lg border border-zinc-200 bg-white p-4 shadow-sm">
            @csrf
            <div>
                <label for="persentase_bunga_bawaan" class="form-label">Bunga Bawaan (%)</label>
                <input id="persentase_bunga_bawaan" name="persentase_bunga_bawaan" type="number" step="0.01" value="{{ $persentaseBungaBawaan }}" class="form-input w-44">
            </div>
            <button class="tombol tombol-sekunder">Simpan Bunga</button>
        </form>
    @endif

    <div class="pembungkus-tabel">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Anggota</th>
                    <th>Jumlah</th>
                    <th>Durasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($daftarPinjaman as $pinjaman)
                    <tr>
                        <td>{{ $pinjaman->tanggal_pengajuan }}</td>
                        <td class="font-semibold text-zinc-950">{{ $pinjaman->anggota->nama }}</td>
                        <td class="font-semibold text-zinc-950">Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $pinjaman->durasi_bulan }} bulan</td>
                        <td>
                            <span class="badge badge-{{ $pinjaman->status }}">
                                {{ ucfirst($pinjaman->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('pinjaman.detail', $pinjaman->id) }}" class="tautan-aksi">Detail</a>
                                @if(in_array(auth()->user()->peran, ['admin', 'manajer', 'kasir']) && $pinjaman->status === 'menunggu')
                                    <a href="{{ route('pinjaman.ubah', $pinjaman->id) }}" class="tautan-aksi-biru">Ubah</a>
                                @endif
                                @if(in_array(auth()->user()->peran, ['admin', 'manajer']) && $pinjaman->status === 'menunggu')
                                    <form action="{{ route('pinjaman.setujui', $pinjaman->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button class="tautan-aksi">Setujui</button>
                                    </form>
                                    <form action="{{ route('pinjaman.tolak', $pinjaman->id) }}" method="POST" onsubmit="return confirm('Tolak pinjaman ini?')">
                                        @csrf
                                        @method('PUT')
                                        <button class="font-semibold text-zinc-600 hover:text-zinc-900">Tolak</button>
                                    </form>
                                @endif
                                @if(in_array(auth()->user()->peran, ['admin', 'manajer']))
                                    <form action="{{ route('pinjaman.hapus', $pinjaman->id) }}" method="POST" onsubmit="return confirm('Hapus pinjaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="tautan-aksi-merah">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="baris-kosong">Belum ada pinjaman. Buat pengajuan dari tombol Ajukan Pinjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $daftarPinjaman->links() }}</div>
@endsection
