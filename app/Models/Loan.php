<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'member_id',
        'amount',
        'interest_rate',
        'duration',
        'status',
        'approved_by',
        'application_date',
        'approval_date',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'member_id'); // Explicit FK since we kept column member_id
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
