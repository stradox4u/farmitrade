<?php

namespace App;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use Uuids;

    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shipping_address', 'phone_number', 'billing_address', 'profile_image', 'bank_name', 'account_number', 'account_verified', 'recipient_code',
    ];
}
