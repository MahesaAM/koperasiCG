<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
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
