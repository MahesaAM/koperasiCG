@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Tambah Pengguna</h1>
            <p>Buat akun internal untuk admin, manajer, kasir, atau anggota.</p>
        </div>
    </div>

    <form action="{{ route('pengguna.simpan') }}" method="POST" class="form-grid">
        @csrf
        @include('pengguna.formulir', ['pengguna' => null, 'wajibKataSandi' => true])
        <div class="md:col-span-2 flex flex-col gap-3 sm:flex-row">
            <button class="tombol tombol-primer">Simpan</button>
            <a href="{{ route('pengguna.daftar') }}" class="tombol tombol-netral">Batal</a>
        </div>
    </form>
@endsection
