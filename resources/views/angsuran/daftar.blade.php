@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Angsuran</h1>
            <p>Catat pembayaran pinjaman dan verifikasi bukti angsuran.</p>
        </div>
        <a href="{{ route('angsuran.tambah') }}" class="tombol tombol-primer">Bayar Angsuran</a>
    </div>

    <div class="pembungkus-tabel">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Anggota</th>
                    <th>Pinjaman</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($daftarAngsuran as $angsuran)
                    <tr>
                        <td>{{ $angsuran->tanggal_bayar }}</td>
                        <td class="font-semibold text-zinc-950">{{ $angsuran->pinjaman->anggota->nama }}</td>
                        <td>#{{ $angsuran->pinjaman_id }}</td>
                        <td class="font-semibold text-zinc-950">Rp {{ number_format($angsuran->jumlah_dibayar, 0, ',', '.') }}</td>
                        <td><span class="badge badge-{{ $angsuran->status }}">{{ ucfirst($angsuran->status) }}</span></td>
                        <td>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('angsuran.detail', $angsuran->id) }}" class="tautan-aksi">Detail</a>
                                @if($angsuran->berkas_bukti)
                                    <a href="{{ asset('storage/' . $angsuran->berkas_bukti) }}" target="_blank" class="tautan-aksi-biru">Bukti</a>
                                @endif
                                @if(in_array(auth()->user()->peran, ['admin', 'manajer']) && $angsuran->status === 'menunggu')
                                    <form action="{{ route('angsuran.setujui', $angsuran->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button class="tautan-aksi">Setujui</button>
                                    </form>
                                    <form action="{{ route('angsuran.tolak', $angsuran->id) }}" method="POST" onsubmit="return confirm('Tolak angsuran ini?')">
                                        @csrf
                                        @method('PUT')
                                        <button class="font-semibold text-zinc-600 hover:text-zinc-900">Tolak</button>
                                    </form>
                                @endif
                                @if(in_array(auth()->user()->peran, ['admin', 'manajer']))
                                    <form action="{{ route('angsuran.hapus', $angsuran->id) }}" method="POST" onsubmit="return confirm('Hapus angsuran ini?')">
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
                        <td colspan="6" class="baris-kosong">Belum ada angsuran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $daftarAngsuran->links() }}</div>
@endsection
