<div>
    <label for="nama" class="form-label">Nama</label>
    <input id="nama" name="nama" value="{{ old('nama', $pengguna?->nama) }}" required class="form-input">
</div>
<div>
    <label for="email" class="form-label">Email</label>
    <input id="email" name="email" type="email" value="{{ old('email', $pengguna?->email) }}" required class="form-input">
</div>
<div>
    <label for="peran" class="form-label">Peran</label>
    <select id="peran" name="peran" required class="form-input">
        <option value="admin" @selected(old('peran', $pengguna?->peran) === 'admin')>Admin</option>
        <option value="manajer" @selected(old('peran', $pengguna?->peran) === 'manajer')>Manajer</option>
        <option value="kasir" @selected(old('peran', $pengguna?->peran) === 'kasir')>Kasir</option>
        <option value="anggota" @selected(old('peran', $pengguna?->peran ?? 'anggota') === 'anggota')>Anggota</option>
    </select>
</div>
<div>
    <label for="kata_sandi" class="form-label">Kata Sandi</label>
    <input id="kata_sandi" name="kata_sandi" type="password" @if($wajibKataSandi) required @endif class="form-input">
</div>
<div>
    <label for="kata_sandi_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
    <input id="kata_sandi_confirmation" name="kata_sandi_confirmation" type="password" @if($wajibKataSandi) required @endif class="form-input">
</div>
