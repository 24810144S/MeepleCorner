<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'last_name',
        'first_name',
        'address',
        'phone',
        'email',
        'password',
        'subscribe_events',
    ];
}
