@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Detail Simpanan</h1>
            <p>Rincian transaksi dan bukti pendukung.</p>
        </div>
        <a href="{{ route('simpanan.daftar') }}" class="tombol tombol-netral">Kembali</a>
    </div>

    <div class="panel-isi">
        <dl class="detail-grid">
            <div class="detail-item"><dt>Anggota</dt><dd>{{ $simpanan->anggota->nama }}</dd></div>
            <div class="detail-item"><dt>Tanggal</dt><dd>{{ $simpanan->tanggal_transaksi }}</dd></div>
            <div class="detail-item"><dt>Jenis</dt><dd>{{ ucfirst($simpanan->jenis) }}</dd></div>
            <div class="detail-item"><dt>Transaksi</dt><dd>{{ $simpanan->jenis_transaksi === 'setoran' ? 'Setoran' : 'Penarikan' }}</dd></div>
            <div class="detail-item"><dt>Jumlah</dt><dd>Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}</dd></div>
            <div class="detail-item"><dt>Status</dt><dd><span class="badge badge-{{ $simpanan->status }}">{{ ucfirst($simpanan->status) }}</span></dd></div>
            <div class="detail-item md:col-span-2"><dt>Keterangan</dt><dd>{{ $simpanan->keterangan ?? '-' }}</dd></div>
            @if($simpanan->berkas_bukti)
                <div class="detail-item md:col-span-2"><dt>Bukti</dt><dd><a href="{{ asset('storage/' . $simpanan->berkas_bukti) }}" target="_blank" class="tautan-aksi">Lihat Berkas</a></dd></div>
            @endif
        </dl>
    </div>
@endsection
