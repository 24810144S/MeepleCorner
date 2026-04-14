<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    protected $fillable = [
        'member_id',
        'space_id',
        'reservation_date',
        'start_time',
        'end_time',
        'status',
        'is_private_booking',  // Make sure this line exists
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_private_booking' => 'boolean',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function space()
    {
        return $this->belongsTo(Space::class);
    }
    
    public function getDurationAttribute()
    {
        return Carbon::parse($this->start_time)->diffInHours(Carbon::parse($this->end_time));
    }
    
    public function getBookingTypeLabelAttribute()
    {
        return $this->is_private_booking ? 'Private Room Booking' : 'Public Table Booking';
    }
}