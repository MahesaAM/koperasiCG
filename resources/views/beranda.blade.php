@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Beranda</h1>
            <p>Ringkasan aktivitas koperasi dan pintasan pekerjaan harian.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('simpanan.tambah') }}" class="tombol tombol-primer">Catat Simpanan</a>
            <a href="{{ route('pinjaman.tambah') }}" class="tombol tombol-netral">Ajukan Pinjaman</a>
        </div>
    </div>

    @isset($peringatan)
        <div class="mb-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-800">{{ $peringatan }}</div>
    @endisset

    <section class="grid gap-4 md:grid-cols-3">
        <div class="kartu-ringkas">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <div class="label-kecil">Total Anggota</div>
                    <div class="angka-besar">{{ $totalAnggota }}</div>
                </div>
                <span class="badge badge-aktif">Profil</span>
            </div>
        </div>
        <div class="kartu-ringkas">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <div class="label-kecil">Total Simpanan</div>
                    <div class="angka-besar">Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</div>
                </div>
                <span class="badge bg-sky-50 text-sky-800 ring-1 ring-inset ring-sky-200">Saldo</span>
            </div>
        </div>
        <div class="kartu-ringkas">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <div class="label-kecil">Pinjaman Aktif</div>
                    <div class="angka-besar">{{ $pinjamanAktif }}</div>
                </div>
                <span class="badge badge-menunggu">Berjalan</span>
            </div>
        </div>
    </section>

    <section class="mt-6 grid gap-4 lg:grid-cols-[1.4fr_1fr]">
        <div class="panel-isi">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold">Pintasan Kerja</h2>
                    <p class="mt-1 text-sm text-zinc-600">Akses cepat ke alur yang paling sering dipakai.</p>
                </div>
            </div>
            <div class="divide-y divide-zinc-100">
                @if(auth()->user()->peran !== 'anggota')
                    <a href="{{ route('anggota.tambah') }}" class="flex items-center justify-between gap-4 py-3 hover:text-blue-800">
                        <span>
                            <span class="block font-bold text-zinc-950">Tambah Anggota</span>
                            <span class="mt-1 block text-sm text-zinc-600">Input data anggota baru.</span>
                        </span>
                        <span class="text-sm font-bold">Buka</span>
                    </a>
                    <a href="{{ route('simpanan.daftar') }}" class="flex items-center justify-between gap-4 py-3 hover:text-blue-800">
                        <span>
                            <span class="block font-bold text-zinc-950">Kelola Simpanan</span>
                            <span class="mt-1 block text-sm text-zinc-600">Pantau setoran dan penarikan.</span>
                        </span>
                        <span class="text-sm font-bold">Buka</span>
                    </a>
                    <a href="{{ route('pinjaman.daftar') }}" class="flex items-center justify-between gap-4 py-3 hover:text-blue-800">
                        <span>
                            <span class="block font-bold text-zinc-950">Kelola Pinjaman</span>
                            <span class="mt-1 block text-sm text-zinc-600">Setujui atau tolak pengajuan.</span>
                        </span>
                        <span class="text-sm font-bold">Buka</span>
                    </a>
                    <a href="{{ route('laporan.daftar') }}" class="flex items-center justify-between gap-4 py-3 hover:text-blue-800">
                        <span>
                            <span class="block font-bold text-zinc-950">Lihat Laporan</span>
                            <span class="mt-1 block text-sm text-zinc-600">Buka laporan siap cetak.</span>
                        </span>
                        <span class="text-sm font-bold">Buka</span>
                    </a>
                @else
                    <a href="{{ route('simpanan.daftar') }}" class="flex items-center justify-between gap-4 py-3 hover:text-blue-800">
                        <span>
                            <span class="block font-bold text-zinc-950">Riwayat Simpanan</span>
                            <span class="mt-1 block text-sm text-zinc-600">Lihat daftar simpanan Anda.</span>
                        </span>
                        <span class="text-sm font-bold">Buka</span>
                    </a>
                    <a href="{{ route('pinjaman.daftar') }}" class="flex items-center justify-between gap-4 py-3 hover:text-blue-800">
                        <span>
                            <span class="block font-bold text-zinc-950">Riwayat Pinjaman</span>
                            <span class="mt-1 block text-sm text-zinc-600">Pantau pinjaman Anda.</span>
                        </span>
                        <span class="text-sm font-bold">Buka</span>
                    </a>
                    <a href="{{ route('angsuran.tambah') }}" class="flex items-center justify-between gap-4 py-3 hover:text-blue-800">
                        <span>
                            <span class="block font-bold text-zinc-950">Bayar Angsuran</span>
                            <span class="mt-1 block text-sm text-zinc-600">Lakukan pembayaran tagihan.</span>
                        </span>
                        <span class="text-sm font-bold">Buka</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="panel-isi">
            <h2 class="text-lg font-bold">Sesi Pengguna</h2>
            <dl class="mt-4 space-y-3">
                <div class="detail-item">
                    <dt>Nama</dt>
                    <dd>{{ auth()->user()->nama }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Peran</dt>
                    <dd>{{ auth()->user()->peran }}</dd>
                </div>
                <div class="detail-item">
                    <dt>Email</dt>
                    <dd>{{ auth()->user()->email }}</dd>
                </div>
            </dl>
        </div>
    </section>
@endsection
