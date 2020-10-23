<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaystackSubaccount extends Model
{
    protected $fillable = [
        'business_name', 'settlement_bank', 'account_number', 'percentage_charge', 'description', 'subaccount_code',
    ];
}
