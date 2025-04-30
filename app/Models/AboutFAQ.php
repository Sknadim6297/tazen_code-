<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutFAQ extends Model
{
    use HasFactory;
    protected $fillable = [
        'faq_description',
        'question1',
        'answer1',
        'question2',
        'answer2',
        'question3',
        'answer3',
        'question4',
        'answer4',
    ];
    
}
