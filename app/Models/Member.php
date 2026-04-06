<?php

namespace App\Models;

// Change this line to use Authenticatable
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'last_name',
        'first_name',
        'address',
        'phone',
        'email',
        'password',
        'subscribe_events',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}