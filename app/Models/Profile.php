<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'professional_id',
        'name',
        'email',
        'phone',
        'specialization',
        'experience',
        'starting_price',
        'address',
        'education',
        'education2', 
        'comments',
        'photo',
        'gallery',
        'qualification_document',
        'id_proof_document',
        'gst_number',
        'gst_certificate',
        'gst_address',
        'state_code',
        'state_name',
        'full_address',
    ];
    
    // Note: gallery is stored as JSON string, manually handled in controllers
    
    /**
     * Safely get gallery as array
     * Handles various data formats and ensures we always get an array
     */
    public function getGalleryArrayAttribute()
    {
        $gallery = $this->gallery;
        
        if (empty($gallery) || $gallery === 'null') {
            return [];
        }
        
        if (is_array($gallery)) {
            return array_filter($gallery); // Remove empty values
        }
        
        if (is_string($gallery)) {
            // Try to decode JSON
            $decoded = json_decode($gallery, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return array_filter($decoded); // Remove empty values
            }
            
            // If it's not valid JSON but looks like a file path, treat as single image
            if (str_contains($gallery, '/') || str_contains($gallery, '\\')) {
                return [$gallery];
            }
        }
        
        return [];
    }
    
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}
