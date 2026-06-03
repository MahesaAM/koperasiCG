<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    public const CREATED_AT = 'dibuat_pada';

    public const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'simpanan';

    protected $fillable = [
        'anggota_id',
        'jenis',
        'jenis_transaksi',
        'jumlah',
        'tanggal_transaksi',
        'keterangan',
        'status',
        'berkas_bukti',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
