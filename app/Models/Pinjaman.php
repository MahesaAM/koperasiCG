<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    public const CREATED_AT = 'dibuat_pada';

    public const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'pinjaman';

    protected $fillable = [
        'anggota_id',
        'jumlah',
        'persentase_bunga',
        'durasi_bulan',
        'status',
        'disetujui_oleh',
        'tanggal_pengajuan',
        'tanggal_persetujuan',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function penyetuju()
    {
        return $this->belongsTo(Pengguna::class, 'disetujui_oleh');
    }

    public function angsuran()
    {
        return $this->hasMany(Angsuran::class);
    }
}
