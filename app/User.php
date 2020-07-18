<?php

namespace App;

use willvincent\Rateable\Rateable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use Rateable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'user_type', 'successful_transactions',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function listings()
    {
        return $this->hasMany('App\Listing');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function canEdit($profile)
    {
        if($this->profile()->where('id', $profile->id)->first())
        {
            return true;
        }
        return false;
    }
}
