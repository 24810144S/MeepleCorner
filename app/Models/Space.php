<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    protected $table = 'spaces';
    
    protected $fillable = [
        'name',
        'type',
        'capacity',
        'description',
        'image',  
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
    
    // Helper to get image URL - FIXED VERSION
    public function getImageUrlAttribute()
    {
        // Check if image exists in database
        if ($this->image) {
            // Check if file exists in public folder
            $fullPath = public_path($this->image);
            if (file_exists($fullPath)) {
                return asset($this->image);
            }
        }
        
        // Return default image based on table type (optional)
        if ($this->type === 'private') {
            return asset('img/default-private.jpg');
        } elseif ($this->type === 'premium') {
            return asset('img/default-premium.jpg');
        }
        
        // Return null if no image (will show icon fallback)
        return null;
    }
}