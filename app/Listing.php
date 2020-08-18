<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function transaction()
    {
        return $this->hasOne('App\Transaction');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'produce', 'produce_quality', 'location', 'buy_sell', 'quantity', 'unit', 'unit_price', 'filled',
    ];
}
