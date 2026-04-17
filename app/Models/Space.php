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
    
    // Helper to get image URL
    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        
        // Return default image based on table type
        if ($this->type === 'private') {
            return asset('img/default-private.jpg');
        } elseif ($this->type === 'premium') {
            return asset('img/default-premium.jpg');
        } else {
            return asset('img/default-table.jpg');
        }
    }
}