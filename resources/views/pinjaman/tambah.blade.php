@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Ajukan Pinjaman</h1>
            <p>Pilih anggota, jumlah pinjaman, bunga, dan durasi pengembalian.</p>
        </div>
    </div>

    <form action="{{ route('pinjaman.simpan') }}" method="POST" class="form-grid">
        @csrf
        @include('pinjaman.formulir', ['pinjaman' => null])
        <div class="md:col-span-2 flex flex-col gap-3 sm:flex-row">
            <button class="tombol tombol-primer">Simpan</button>
            <a href="{{ route('pinjaman.daftar') }}" class="tombol tombol-netral">Batal</a>
        </div>
    </form>
@endsection
