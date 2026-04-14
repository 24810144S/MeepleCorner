<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    protected $table = 'spaces';  // Explicitly specify table name
    
    protected $fillable = [
        'name',
        'type',
        'capacity',
        'description',
        'is_active',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    // Helper method to get size category
    public function getSizeCategoryAttribute()
    {
        if ($this->type === 'private') {
            return 'private';
        }
        
        if ($this->capacity <= 3) {
            return 'small';
        } elseif ($this->capacity <= 6) {
            return 'medium';
        } else {
            return 'large';
        }
    }
    
    // Check if this is a public table
    public function isPublicTable()
    {
        return $this->type !== 'private';
    }
}