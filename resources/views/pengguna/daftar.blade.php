@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Pengguna</h1>
            <p>Kelola akun yang dapat masuk ke aplikasi dan hak aksesnya.</p>
        </div>
        <a href="{{ route('pengguna.tambah') }}" class="tombol tombol-primer">Tambah Pengguna</a>
    </div>

    <div class="pembungkus-tabel">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Peran</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($daftarPengguna as $pengguna)
                    <tr>
                        <td class="font-semibold text-zinc-950">{{ $pengguna->nama }}</td>
                        <td>{{ $pengguna->email }}</td>
                        <td><span class="badge badge-aktif">{{ ucfirst($pengguna->peran) }}</span></td>
                        <td>{{ $pengguna->dibuat_pada?->format('d M Y') }}</td>
                        <td>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('pengguna.ubah', $pengguna->id) }}" class="tautan-aksi-biru">Ubah</a>
                                @if($pengguna->id !== auth()->id())
                                    <form action="{{ route('pengguna.hapus', $pengguna->id) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
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
                        <td colspan="5" class="baris-kosong">Belum ada pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $daftarPengguna->links() }}</div>
@endsection
