<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_id',
        'feature_heading',
        'order'
    ];

    /**
     * Get the header that owns the feature
     */
    public function header()
    {
        return $this->belongsTo(Header::class);
    }

    /**
     * Get the services for the feature
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'header_feature_services', 'header_feature_id', 'service_id');
    }
}

