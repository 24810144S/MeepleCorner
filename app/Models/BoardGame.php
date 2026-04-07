<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardGame extends Model
{
    protected $fillable = ['name', 'description', 'category', 'min_players', 'max_players', 'play_time_minutes', 'image', 'is_available'];
}