@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Detail Pinjaman</h1>
            <p>Rincian tagihan, persetujuan, dan riwayat angsuran.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            @if($pinjaman->status === 'disetujui')
                <a href="{{ route('angsuran.tambah', ['pinjaman_id' => $pinjaman->id]) }}" class="tombol tombol-primer">Bayar Angsuran</a>
            @endif
            <a href="{{ route('pinjaman.daftar') }}" class="tombol tombol-netral">Kembali</a>
        </div>
    </div>

    @php
        $totalBunga = $pinjaman->jumlah * ($pinjaman->persentase_bunga / 100);
        $totalTagihan = $pinjaman->jumlah + $totalBunga;
    @endphp

    <div class="panel-isi">
        <dl class="detail-grid">
            <div class="detail-item"><dt>Anggota</dt><dd>{{ $pinjaman->anggota->nama }}</dd></div>
            <div class="detail-item"><dt>Status</dt><dd><span class="badge badge-{{ $pinjaman->status }}">{{ ucfirst($pinjaman->status) }}</span></dd></div>
            <div class="detail-item"><dt>Jumlah</dt><dd>Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }}</dd></div>
            <div class="detail-item"><dt>Bunga</dt><dd>{{ $pinjaman->persentase_bunga }}%</dd></div>
            <div class="detail-item"><dt>Durasi</dt><dd>{{ $pinjaman->durasi_bulan }} bulan</dd></div>
            <div class="detail-item"><dt>Total Tagihan</dt><dd>Rp {{ number_format($totalTagihan, 0, ',', '.') }}</dd></div>
            <div class="detail-item"><dt>Tanggal Pengajuan</dt><dd>{{ $pinjaman->tanggal_pengajuan }}</dd></div>
            <div class="detail-item"><dt>Disetujui Oleh</dt><dd>{{ $pinjaman->penyetuju?->nama ?? '-' }}</dd></div>
        </dl>
    </div>

    <div class="mt-6 panel-isi">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold">Riwayat Angsuran</h2>
                <p class="mt-1 text-sm text-zinc-600">Pembayaran yang tercatat untuk pinjaman ini.</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="tabel-data">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pinjaman->angsuran as $angsuran)
                        <tr>
                            <td>{{ $angsuran->tanggal_bayar }}</td>
                            <td class="font-semibold">Rp {{ number_format($angsuran->jumlah_dibayar, 0, ',', '.') }}</td>
                            <td><span class="badge badge-{{ $angsuran->status }}">{{ ucfirst($angsuran->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="baris-kosong">Belum ada angsuran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
