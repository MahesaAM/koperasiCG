@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Ubah Anggota</h1>
            <p>Perbarui data anggota agar transaksi dan laporan tetap akurat.</p>
        </div>
    </div>

    <form action="{{ route('anggota.perbarui', $anggota->id) }}" method="POST" class="form-grid">
        @csrf
        @method('PUT')
        @include('anggota.formulir', ['anggota' => $anggota])
        <div class="md:col-span-2 flex flex-col gap-3 sm:flex-row">
            <button class="tombol tombol-primer">Perbarui</button>
            <a href="{{ route('anggota.daftar') }}" class="tombol tombol-netral">Batal</a>
        </div>
    </form>
@endsection
