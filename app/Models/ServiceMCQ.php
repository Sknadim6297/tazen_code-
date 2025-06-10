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
        'has_other_option',
        'answer1',
        'answer2',
        'answer3',
        'answer4'
    ];

    protected $casts = [
        'options' => 'array',
        'has_other_option' => 'boolean'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
