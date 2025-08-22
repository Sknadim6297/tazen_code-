<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'category',
        'duration',
        'description',
        'features',
        'tags',
        'requirements',
        'image_path',
        'professional_id',
        'service_id',
    ];

    // Define relationships
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    
    public function subServices()
    {
        return $this->belongsToMany(SubService::class, 'prof_service_sub_services', 'professional_service_id', 'sub_service_id');
    }
    
    protected $casts = [
        'features' => 'array',
    ];
}
