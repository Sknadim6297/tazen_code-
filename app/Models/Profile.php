<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        // Bank details
        'account_holder_name',
        'bank_name',
        'account_number',
        'ifsc_code',
        'account_type',
        'bank_branch',
        'bank_document',
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
            // Try to decode JSON - handle double encoding
            $decoded = json_decode($gallery, true);
            
            if (json_last_error() === JSON_ERROR_NONE) {
                if (is_array($decoded)) {
                    $filteredArray = array_filter($decoded); // Remove empty values
                    
                    // Validate that files exist, remove broken paths
                    $validImages = [];
                    foreach ($filteredArray as $imagePath) {
                        if ($this->imageExists($imagePath)) {
                            $validImages[] = $imagePath;
                        }
                    }
                    
                    return $validImages;
                }
                
                // Check if the decoded value is still a JSON string (double encoded)
                if (is_string($decoded)) {
                    $doubleDecoded = json_decode($decoded, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($doubleDecoded)) {
                        $filteredArray = array_filter($doubleDecoded); // Remove empty values
                        
                        // Validate that files exist, remove broken paths
                        $validImages = [];
                        foreach ($filteredArray as $imagePath) {
                            if ($this->imageExists($imagePath)) {
                                $validImages[] = $imagePath;
                            }
                        }
                        
                        return $validImages;
                    }
                }
            }
            
            // If it's not valid JSON but looks like a file path, treat as single image
            if (str_contains($gallery, '/') || str_contains($gallery, '\\')) {
                return $this->imageExists($gallery) ? [$gallery] : [];
            }
        }
        
        return [];
    }

    /**
     * Check if an image exists in any of the possible locations
     */
    private function imageExists($imagePath)
    {
        if (str_starts_with($imagePath, 'gallery/')) {
            // New format: stored in storage/app/public/gallery/
            return Storage::disk('public')->exists($imagePath);
        } elseif (str_starts_with($imagePath, 'uploads/')) {
            // Old format: stored in public/uploads/
            return file_exists(public_path($imagePath));
        } elseif (str_starts_with($imagePath, 'storage/')) {
            // Storage path format
            return file_exists(public_path($imagePath));
        } else {
            // Try common locations
            return Storage::disk('public')->exists('gallery/'.$imagePath) || 
                   file_exists(public_path('uploads/professionals/gallery/'.$imagePath)) ||
                   file_exists(public_path('uploads/profiles/gallery/'.$imagePath));
        }
    }
    
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}
