@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Detail Angsuran</h1>
            <p>Rincian pembayaran, alokasi pokok, bunga, dan bukti bayar.</p>
        </div>
        <a href="{{ route('angsuran.daftar') }}" class="tombol tombol-netral">Kembali</a>
    </div>

    <div class="panel-isi">
        <dl class="detail-grid">
            <div class="detail-item"><dt>Tanggal Bayar</dt><dd>{{ $angsuran->tanggal_bayar }}</dd></div>
            <div class="detail-item"><dt>Anggota</dt><dd>{{ $angsuran->pinjaman->anggota->nama }}</dd></div>
            <div class="detail-item"><dt>Pinjaman</dt><dd>#{{ $angsuran->pinjaman_id }}</dd></div>
            <div class="detail-item"><dt>Jumlah Dibayar</dt><dd>Rp {{ number_format($angsuran->jumlah_dibayar, 0, ',', '.') }}</dd></div>
            <div class="detail-item"><dt>Pokok Dibayar</dt><dd>Rp {{ number_format($angsuran->pokok_dibayar, 0, ',', '.') }}</dd></div>
            <div class="detail-item"><dt>Bunga Dibayar</dt><dd>Rp {{ number_format($angsuran->bunga_dibayar, 0, ',', '.') }}</dd></div>
            <div class="detail-item"><dt>Status</dt><dd><span class="badge badge-{{ $angsuran->status }}">{{ ucfirst($angsuran->status) }}</span></dd></div>
            <div class="detail-item"><dt>Catatan</dt><dd>{{ $angsuran->catatan ?? '-' }}</dd></div>
            @if($angsuran->berkas_bukti)
                <div class="detail-item md:col-span-2"><dt>Bukti</dt><dd><a href="{{ asset('storage/' . $angsuran->berkas_bukti) }}" target="_blank" class="tautan-aksi">Lihat Berkas</a></dd></div>
            @endif
        </dl>
    </div>
@endsection
