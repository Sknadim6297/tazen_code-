<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'question',
        'answer',
        'status'
    ];

    const CATEGORIES = [
        'General',
        'Event',
        'Registration',
        'Payment',
        'Cancellation',
        'Reviews'
    ];
}
