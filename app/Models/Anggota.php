<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'members'; // Keep table name for now to avoid data migration issues, or user wants FULL indo?
    // Let's stick to 'members' table for safety unless instructed, but code is Anggota.
    // Actually, migration 2026_02_04_053701_create_members_table.php created 'members'.
    // Changing table name requires migration. I will add protected $table = 'members'; explicitly just in case.
    protected $fillable = [
        'user_id',
        'nik',
        'name',
        'address',
        'phone',
        'join_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
