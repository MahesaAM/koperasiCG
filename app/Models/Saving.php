<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    protected $fillable = [
        'member_id',
        'type',
        'transaction_type',
        'amount',
        'transaction_date',
        'description',
        'status',
        'proof_file',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'member_id'); // Explicit FK
    }
}
