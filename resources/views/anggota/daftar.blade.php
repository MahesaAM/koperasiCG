@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Anggota</h1>
            <p>Kelola profil anggota dan hubungkan anggota dengan akun pengguna.</p>
        </div>
        <a href="{{ route('anggota.tambah') }}" class="tombol tombol-primer">Tambah Anggota</a>
    </div>

    <div class="pembungkus-tabel">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Status</th>
                    <th>Akun</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($daftarAnggota as $anggota)
                    <tr>
                        <td class="font-mono text-xs">{{ $anggota->nik }}</td>
                        <td class="font-semibold text-zinc-950">{{ $anggota->nama }}</td>
                        <td>{{ $anggota->telepon }}</td>
                        <td>
                            <span class="badge {{ $anggota->status === 'aktif' ? 'badge-aktif' : 'badge-tidak-aktif' }}">
                                {{ $anggota->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>{{ $anggota->pengguna_id ? 'Terhubung' : 'Belum ada' }}</td>
                        <td>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('anggota.detail', $anggota->id) }}" class="tautan-aksi">Detail</a>
                                <a href="{{ route('anggota.ubah', $anggota->id) }}" class="tautan-aksi-biru">Ubah</a>
                                @if(! $anggota->pengguna_id)
                                    <form action="{{ route('anggota.buat_akun', $anggota->id) }}" method="POST">
                                        @csrf
                                        <button class="tautan-aksi">Buat Akun</button>
                                    </form>
                                @endif
                                <form action="{{ route('anggota.hapus', $anggota->id) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="tautan-aksi-merah">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="baris-kosong">Belum ada anggota. Mulai dari tombol Tambah Anggota.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $daftarAnggota->links() }}</div>
@endsection
