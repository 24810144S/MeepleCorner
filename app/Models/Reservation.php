<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'member_id',
        'space_id',
        'reservation_date',
        'time_slot',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function space()
    {
        return $this->belongsTo(Space::class);
    }
}
