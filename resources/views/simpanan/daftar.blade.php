@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Simpanan</h1>
            <p>Catat setoran, penarikan, dan verifikasi bukti transaksi anggota.</p>
        </div>
        <a href="{{ route('simpanan.tambah') }}" class="tombol tombol-primer">Tambah Transaksi</a>
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
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($daftarSimpanan as $simpanan)
                    <tr>
                        <td>{{ $simpanan->tanggal_transaksi }}</td>
                        <td class="font-semibold text-zinc-950">{{ $simpanan->anggota->nama }}</td>
                        <td>{{ ucfirst($simpanan->jenis) }}</td>
                        <td>{{ $simpanan->jenis_transaksi === 'setoran' ? 'Setoran' : 'Penarikan' }}</td>
                        <td class="font-semibold text-zinc-950">Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}</td>
                        <td><span class="badge badge-{{ $simpanan->status }}">{{ ucfirst($simpanan->status) }}</span></td>
                        <td>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('simpanan.detail', $simpanan->id) }}" class="tautan-aksi">Detail</a>
                                @if($simpanan->berkas_bukti)
                                    <a href="{{ asset('storage/' . $simpanan->berkas_bukti) }}" target="_blank" class="tautan-aksi-biru">Bukti</a>
                                @endif
                                @if(in_array(auth()->user()->peran, ['admin', 'manajer']) && $simpanan->status === 'menunggu')
                                    <form action="{{ route('simpanan.setujui', $simpanan->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button class="tautan-aksi">Setujui</button>
                                    </form>
                                    <form action="{{ route('simpanan.tolak', $simpanan->id) }}" method="POST" onsubmit="return confirm('Tolak transaksi ini?')">
                                        @csrf
                                        @method('PUT')
                                        <button class="font-semibold text-zinc-600 hover:text-zinc-900">Tolak</button>
                                    </form>
                                @endif
                                @if(in_array(auth()->user()->peran, ['admin', 'manajer']))
                                    <form action="{{ route('simpanan.hapus', $simpanan->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
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
                        <td colspan="7" class="baris-kosong">Belum ada transaksi simpanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $daftarSimpanan->links() }}</div>
@endsection
