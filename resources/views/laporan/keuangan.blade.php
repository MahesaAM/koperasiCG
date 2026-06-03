@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Laporan Keuangan</h1>
            <p>Ringkasan posisi keuangan koperasi saat ini.</p>
        </div>
        <button onclick="window.print()" class="tombol tombol-sekunder">Cetak</button>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div class="kartu-ringkas"><div class="label-kecil">Total Simpanan</div><div class="angka-besar">Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</div></div>
        <div class="kartu-ringkas"><div class="label-kecil">Pinjaman Disalurkan</div><div class="angka-besar">Rp {{ number_format($totalPinjamanDisalurkan, 0, ',', '.') }}</div></div>
        <div class="kartu-ringkas"><div class="label-kecil">Sisa Pinjaman</div><div class="angka-besar">Rp {{ number_format($sisaPinjaman, 0, ',', '.') }}</div></div>
        <div class="kartu-ringkas"><div class="label-kecil">Pendapatan Bunga</div><div class="angka-besar">Rp {{ number_format($totalPendapatanBunga, 0, ',', '.') }}</div></div>
    </div>
@endsection
