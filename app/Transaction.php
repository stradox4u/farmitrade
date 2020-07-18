<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function listing()
    {
        return $this->belongsTo('App\Listing');
    }

    public function payment()
    {
        return $this->hasOne('App\Payment');
    }

    public function transfers()
    {
        return $this->hasMany('App\Transfer');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price_of_goods', 'price_of_logistics', 'insurance_premium', 'platform_fee', 'transaction_status', 'produce', 'unit', 'quantity', 'transaction_id_for_paystack', 'delivery_timeframe', 'insurance_premium_paid', 'buyer_is_rated', 'farmer_is_rated',
    ];
}
