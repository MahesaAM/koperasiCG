@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Laporan</h1>
            <p>Pilih laporan yang ingin dilihat atau dicetak.</p>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        <a href="{{ route('laporan.anggota') }}" class="kartu-ringkas hover:border-blue-300">
            <div class="font-bold text-zinc-950">Laporan Anggota</div>
            <div class="mt-1 text-sm text-zinc-600">Status dan daftar anggota.</div>
        </a>
        <a href="{{ route('laporan.simpanan') }}" class="kartu-ringkas hover:border-blue-300">
            <div class="font-bold text-zinc-950">Laporan Simpanan</div>
            <div class="mt-1 text-sm text-zinc-600">Setoran, penarikan, dan saldo.</div>
        </a>
        <a href="{{ route('laporan.pinjaman') }}" class="kartu-ringkas hover:border-blue-300">
            <div class="font-bold text-zinc-950">Laporan Pinjaman</div>
            <div class="mt-1 text-sm text-zinc-600">Pengajuan dan status pinjaman.</div>
        </a>
        <a href="{{ route('laporan.angsuran') }}" class="kartu-ringkas hover:border-blue-300">
            <div class="font-bold text-zinc-950">Laporan Angsuran</div>
            <div class="mt-1 text-sm text-zinc-600">Pembayaran pokok dan bunga.</div>
        </a>
        <a href="{{ route('laporan.keuangan') }}" class="kartu-ringkas hover:border-blue-300">
            <div class="font-bold text-zinc-950">Laporan Keuangan</div>
            <div class="mt-1 text-sm text-zinc-600">Ringkasan posisi koperasi.</div>
        </a>
    </div>
@endsection
