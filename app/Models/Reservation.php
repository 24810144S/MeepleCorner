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
        'is_private_booking',
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
    
    // Check if reservation conflicts with another
    public static function hasConflict($spaceId, $date, $startTime, $endTime, $excludeId = null)
    {
        $query = self::where('space_id', $spaceId)
            ->where('reservation_date', $date)
            ->where(function($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $startTime);
            });
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }
}