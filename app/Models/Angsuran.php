<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    public const CREATED_AT = 'dibuat_pada';

    public const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'angsuran';

    protected $fillable = [
        'pinjaman_id',
        'tanggal_bayar',
        'jumlah_dibayar',
        'bunga_dibayar',
        'pokok_dibayar',
        'catatan',
        'status',
        'berkas_bukti',
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }
}
