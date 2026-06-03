<form action="{{ $rute }}" method="GET" class="mb-6 flex flex-wrap items-end gap-3 rounded-lg border border-zinc-200 bg-white p-4 shadow-sm">
    <div>
        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
        <input id="tanggal_mulai" name="tanggal_mulai" type="date" value="{{ $tanggalMulai ?? '' }}" class="form-input">
    </div>
    <div>
        <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
        <input id="tanggal_akhir" name="tanggal_akhir" type="date" value="{{ $tanggalAkhir ?? '' }}" class="form-input">
    </div>
    <button class="tombol tombol-primer">Tampilkan</button>
</form>
