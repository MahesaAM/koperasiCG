<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = [
        'loan_id',
        'payment_date',
        'amount_paid',
        'interest_paid',
        'principal_paid',
        'note',
        'status',
        'proof_file',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
