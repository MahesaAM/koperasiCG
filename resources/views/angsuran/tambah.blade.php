@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Bayar Angsuran</h1>
            <p>Pilih pinjaman aktif, masukkan jumlah pembayaran, lalu unggah bukti.</p>
        </div>
    </div>

    <form action="{{ route('angsuran.simpan') }}" method="POST" enctype="multipart/form-data" class="form-grid">
        @csrf
        <div class="md:col-span-2">
            <label for="pinjaman_id" class="form-label">Pinjaman</label>
            <select id="pinjaman_id" name="pinjaman_id" required class="form-input">
                @foreach($daftarPinjaman as $pilihanPinjaman)
                    <option value="{{ $pilihanPinjaman->id }}" @selected(old('pinjaman_id', $pinjaman?->id) == $pilihanPinjaman->id)>
                        #{{ $pilihanPinjaman->id }} - {{ $pilihanPinjaman->anggota->nama }} - Rp {{ number_format($pilihanPinjaman->jumlah, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="tanggal_bayar" class="form-label">Tanggal Bayar</label>
            <input id="tanggal_bayar" name="tanggal_bayar" type="date" value="{{ old('tanggal_bayar', now()->toDateString()) }}" required class="form-input">
        </div>
        <div>
            <label for="jumlah_dibayar" class="form-label">Jumlah Dibayar</label>
            <input id="jumlah_dibayar" name="jumlah_dibayar" type="number" min="0" value="{{ old('jumlah_dibayar') }}" required class="form-input">
        </div>
        <div>
            <label for="berkas_bukti" class="form-label">Berkas Bukti</label>
            <input id="berkas_bukti" name="berkas_bukti" type="file" required class="mt-2 block w-full text-sm text-zinc-700">
        </div>
        <div class="md:col-span-2">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea id="catatan" name="catatan" rows="3" class="form-input">{{ old('catatan') }}</textarea>
        </div>
        <div class="md:col-span-2 flex flex-col gap-3 sm:flex-row">
            <button class="tombol tombol-primer">Simpan</button>
            <a href="{{ route('angsuran.daftar') }}" class="tombol tombol-netral">Batal</a>
        </div>
    </form>
@endsection
