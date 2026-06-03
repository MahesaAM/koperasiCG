@extends('tata_letak.aplikasi')

@section('konten')
    <div class="judul-halaman">
        <div>
            <h1>Tambah Simpanan</h1>
            <p>Catat setoran atau penarikan. Anggota dapat mengunggah bukti untuk verifikasi admin.</p>
        </div>
    </div>

    <form action="{{ route('simpanan.simpan') }}" method="POST" enctype="multipart/form-data" class="form-grid">
        @csrf
        <div>
            <label for="anggota_id" class="form-label">Anggota</label>
            <select id="anggota_id" name="anggota_id" required class="form-input">
                @foreach($daftarAnggota as $anggota)
                    <option value="{{ $anggota->id }}" @selected(old('anggota_id') == $anggota->id)>{{ $anggota->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
            <input id="tanggal_transaksi" name="tanggal_transaksi" type="date" value="{{ old('tanggal_transaksi', now()->toDateString()) }}" required class="form-input">
        </div>
        <div>
            <label for="jenis" class="form-label">Jenis Simpanan</label>
            <select id="jenis" name="jenis" required class="form-input">
                <option value="pokok" @selected(old('jenis') === 'pokok')>Pokok</option>
                <option value="wajib" @selected(old('jenis') === 'wajib')>Wajib</option>
                <option value="sukarela" @selected(old('jenis') === 'sukarela')>Sukarela</option>
            </select>
        </div>
        <div>
            <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
            <select id="jenis_transaksi" name="jenis_transaksi" required class="form-input">
                <option value="setoran" @selected(old('jenis_transaksi') === 'setoran')>Setoran</option>
                <option value="penarikan" @selected(old('jenis_transaksi') === 'penarikan')>Penarikan</option>
            </select>
        </div>
        <div>
            <label for="jumlah" class="form-label">Jumlah</label>
            <input id="jumlah" name="jumlah" type="number" min="0" value="{{ old('jumlah') }}" required class="form-input">
        </div>
        <div>
            <label for="berkas_bukti" class="form-label">Berkas Bukti</label>
            <input id="berkas_bukti" name="berkas_bukti" type="file" class="mt-2 block w-full text-sm text-zinc-700">
        </div>
        <div class="md:col-span-2">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea id="keterangan" name="keterangan" rows="3" class="form-input">{{ old('keterangan') }}</textarea>
        </div>
        <div class="md:col-span-2 flex flex-col gap-3 sm:flex-row">
            <button class="tombol tombol-primer">Simpan</button>
            <a href="{{ route('simpanan.daftar') }}" class="tombol tombol-netral">Batal</a>
        </div>
    </form>
@endsection
