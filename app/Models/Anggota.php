<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    public const CREATED_AT = 'dibuat_pada';

    public const UPDATED_AT = 'diperbarui_pada';

    protected $table = 'anggota';

    protected $fillable = [
        'pengguna_id',
        'nik',
        'nama',
        'alamat',
        'telepon',
        'tanggal_bergabung',
        'status',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }

    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class);
    }

    public function simpanan()
    {
        return $this->hasMany(Simpanan::class);
    }
}
