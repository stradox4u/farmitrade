<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function transaction()
    {
        return $this->belongsTo('App\Transaction');
    }

    protected $fillable = [
        'paystack_reference', 'total_amount', 'paystack_fee', 'insurance_paid', 'payment_successful',
    ];
}
