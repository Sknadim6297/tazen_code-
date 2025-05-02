<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event_details';

    public function eventDetails()
    {
        return $this->belongsTo(AllEvent::class, 'event_id');
    }
}
