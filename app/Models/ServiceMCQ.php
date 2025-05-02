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
        'answer1',
        'answer2',
        'answer3',
        'answer4',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
