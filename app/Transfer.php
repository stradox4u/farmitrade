<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    public function transaction()
    {
        return $this->belongsTo('App\Transaction');
    }

    protected $fillable = [
        'transfer_purpose', 'amount', 'transfer_status', 'reference', 'transfer_code',
    ];
}
