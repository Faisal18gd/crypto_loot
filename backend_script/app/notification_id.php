<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notification_id extends Model
{
    protected $fillable = ['email', 'device_token', 'userinfo'];
}
