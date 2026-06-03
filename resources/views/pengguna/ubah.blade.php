@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Ubah Pengguna</h1>
            <p>Perbarui profil, peran, atau kata sandi pengguna.</p>
        </div>
    </div>

    <form action="{{ route('pengguna.perbarui', $pengguna->id) }}" method="POST" class="form-grid">
        @csrf
        @method('PUT')
        @include('pengguna.formulir', ['pengguna' => $pengguna, 'wajibKataSandi' => false])
        <div class="md:col-span-2 flex flex-col gap-3 sm:flex-row">
            <button class="tombol tombol-primer">Perbarui</button>
            <a href="{{ route('pengguna.daftar') }}" class="tombol tombol-netral">Batal</a>
        </div>
    </form>
@endsection
