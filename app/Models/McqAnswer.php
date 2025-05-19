<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McqAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'question_id',
        'answer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function question()
    {
        return $this->belongsTo(ServiceMCQ::class, 'question_id');
    }
}
