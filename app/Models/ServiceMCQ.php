<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceMCQ extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'service_id',
        'question',
        'question_type',
        'options',
        'has_other_option'
    ];

    protected $casts = [
        'options' => 'array',
        'has_other_option' => 'boolean'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get formatted options for display
     */
    public function getFormattedOptionsAttribute()
    {
        if (is_array($this->options)) {
            return $this->options;
        }
        
        // Fallback to answer1-4 format if options is empty
        return array_filter([
            'A' => $this->answer1,
            'B' => $this->answer2,
            'C' => $this->answer3,
            'D' => $this->answer4
        ]);
    }

    /**
     * Get all MCQ questions for a specific service
     */
    public static function getQuestionsForService($serviceId)
    {
        return self::where('service_id', $serviceId)
                   ->where('question_type', 'mcq')
                   ->get();
    }
}
