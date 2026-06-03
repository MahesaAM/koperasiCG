<div>
    <label for="anggota_id" class="form-label">Anggota</label>
    <select id="anggota_id" name="anggota_id" required class="form-input">
        @foreach($daftarAnggota as $anggota)
            <option value="{{ $anggota->id }}" @selected(old('anggota_id', $pinjaman?->anggota_id) == $anggota->id)>{{ $anggota->nama }}</option>
        @endforeach
    </select>
</div>
<div>
    <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
    <input id="tanggal_pengajuan" name="tanggal_pengajuan" type="date" value="{{ old('tanggal_pengajuan', $pinjaman?->tanggal_pengajuan ?? now()->toDateString()) }}" required class="form-input">
</div>
<div>
    <label for="jumlah" class="form-label">Jumlah</label>
    <input id="jumlah" name="jumlah" type="number" min="0" value="{{ old('jumlah', $pinjaman?->jumlah) }}" required class="form-input">
</div>
<div>
    <label for="persentase_bunga" class="form-label">Bunga (%)</label>
    <input id="persentase_bunga" name="persentase_bunga" type="number" min="0" step="0.01" value="{{ old('persentase_bunga', $pinjaman?->persentase_bunga ?? $persentaseBungaBawaan) }}" required class="form-input {{ auth()->user()->peran === 'anggota' ? 'bg-zinc-100 cursor-not-allowed text-zinc-500' : '' }}" {{ auth()->user()->peran === 'anggota' ? 'readonly' : '' }}>
    @if(auth()->user()->peran === 'anggota')
        <p class="mt-1 text-xs text-zinc-500">Bunga pinjaman ditentukan oleh pengurus.</p>
    @endif
</div>
<div>
    <label for="durasi_bulan" class="form-label">Durasi Bulan</label>
    <input id="durasi_bulan" name="durasi_bulan" type="number" min="1" value="{{ old('durasi_bulan', $pinjaman?->durasi_bulan) }}" required class="form-input">
</div>
