<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMCQAnswer extends Model
{
    use HasFactory;

    protected $table = 'user_mcq_answers';

    protected $fillable = [
        'user_id',
        'service_id',
        'service_mcq_id',
        'booking_id',
        'question',
        'selected_answer',
        'other_answer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function serviceMcq()
    {
        return $this->belongsTo(ServiceMCQ::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
