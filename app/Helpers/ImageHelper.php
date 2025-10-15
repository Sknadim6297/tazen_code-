<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Get the URL for a storage image with fallback
     */
    public static function getStorageImageUrl($imagePath, $fallbackPath = 'frontend/assets/img/lazy-placeholder.png')
    {
        if (!$imagePath) {
            return asset($fallbackPath);
        }

        $fullPath = public_path('storage/' . $imagePath);
        
        if (file_exists($fullPath)) {
            return asset('storage/' . $imagePath);
        }

        return asset($fallbackPath);
    }

    /**
     * Get profile image URL with fallback
     */
    public static function getProfileImageUrl($profile, $fallbackPath = 'frontend/assets/img/avatar.jpg')
    {
        if (!$profile || !$profile->photo) {
            return asset($fallbackPath);
        }

        return self::getStorageImageUrl($profile->photo, $fallbackPath);
    }

    /**
     * Get gallery image URL with fallback
     */
    public static function getGalleryImageUrl($imagePath, $fallbackPath = 'frontend/assets/img/lazy-placeholder.png')
    {
        // Handle images that might already have 'storage/' prefix
        $cleanPath = str_replace('storage/', '', $imagePath);
        return self::getStorageImageUrl($cleanPath, $fallbackPath);
    }
}