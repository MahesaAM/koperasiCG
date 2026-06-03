<div>
    <label for="nik" class="form-label">NIK</label>
    <input id="nik" name="nik" value="{{ old('nik', $anggota?->nik) }}" required class="form-input">
</div>
<div>
    <label for="nama" class="form-label">Nama</label>
    <input id="nama" name="nama" value="{{ old('nama', $anggota?->nama) }}" required class="form-input">
</div>
<div>
    <label for="telepon" class="form-label">Telepon</label>
    <input id="telepon" name="telepon" value="{{ old('telepon', $anggota?->telepon) }}" required class="form-input">
</div>
<div>
    <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
    <input id="tanggal_bergabung" name="tanggal_bergabung" type="date" value="{{ old('tanggal_bergabung', $anggota?->tanggal_bergabung) }}" required class="form-input">
</div>
<div class="md:col-span-2">
    <label for="alamat" class="form-label">Alamat</label>
    <textarea id="alamat" name="alamat" rows="3" required class="form-input">{{ old('alamat', $anggota?->alamat) }}</textarea>
</div>
<div>
    <label for="status" class="form-label">Status</label>
    <select id="status" name="status" required class="form-input">
        <option value="aktif" @selected(old('status', $anggota?->status ?? 'aktif') === 'aktif')>Aktif</option>
        <option value="tidak_aktif" @selected(old('status', $anggota?->status) === 'tidak_aktif')>Tidak Aktif</option>
    </select>
</div>
