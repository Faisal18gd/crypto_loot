<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
//    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'ip', 'email', 'password', 'balance', 'avatar', 'referred_by', 'device_id', 'refid', 'banned', 'pending', 'country'
    ];

	public function getJWTIdentifier()
    {
        return $this->getKey();
    }
	public function getJWTCustomClaims()
    {
        return ['user' => ['id' => $this->id]];
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
