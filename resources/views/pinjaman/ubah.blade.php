@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Ubah Pinjaman</h1>
            <p>Pinjaman hanya dapat diubah saat status masih menunggu.</p>
        </div>
    </div>

    <form action="{{ route('pinjaman.perbarui', $pinjaman->id) }}" method="POST" class="form-grid">
        @csrf
        @method('PUT')
        @include('pinjaman.formulir', ['pinjaman' => $pinjaman])
        <div class="md:col-span-2 flex flex-col gap-3 sm:flex-row">
            <button class="tombol tombol-primer">Perbarui</button>
            <a href="{{ route('pinjaman.daftar') }}" class="tombol tombol-netral">Batal</a>
        </div>
    </form>
@endsection
