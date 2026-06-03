@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Detail Anggota</h1>
            <p>Informasi profil anggota dan status akun pengguna.</p>
        </div>
        <a href="{{ route('anggota.daftar') }}" class="tombol tombol-netral">Kembali</a>
    </div>

    <div class="panel-isi">
        <dl class="detail-grid">
            <div class="detail-item"><dt>NIK</dt><dd>{{ $anggota->nik }}</dd></div>
            <div class="detail-item"><dt>Nama</dt><dd>{{ $anggota->nama }}</dd></div>
            <div class="detail-item"><dt>Telepon</dt><dd>{{ $anggota->telepon }}</dd></div>
            <div class="detail-item"><dt>Tanggal Bergabung</dt><dd>{{ $anggota->tanggal_bergabung }}</dd></div>
            <div class="detail-item"><dt>Status</dt><dd>{{ $anggota->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}</dd></div>
            <div class="detail-item"><dt>Akun Pengguna</dt><dd>{{ $anggota->pengguna?->email ?? '-' }}</dd></div>
            <div class="detail-item md:col-span-2"><dt>Alamat</dt><dd>{{ $anggota->alamat }}</dd></div>
        </dl>
    </div>
@endsection
