@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Tambah Anggota</h1>
            <p>Isi data dasar anggota. Akun login dapat dibuat setelah data anggota tersimpan.</p>
        </div>
    </div>

    <form action="{{ route('anggota.simpan') }}" method="POST" class="form-grid">
        @csrf
        @include('anggota.formulir', ['anggota' => null])
        <div class="md:col-span-2 flex flex-col gap-3 sm:flex-row">
            <button class="tombol tombol-primer">Simpan</button>
            <a href="{{ route('anggota.daftar') }}" class="tombol tombol-netral">Batal</a>
        </div>
    </form>
@endsection
