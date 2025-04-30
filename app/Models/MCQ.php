<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCQ extends Model
{
    use HasFactory;
    protected $fillable = [
        'question1', 'option1_a', 'option1_b', 'option1_c', 'option1_d',
        'question2', 'option2_a', 'option2_b', 'option2_c', 'option2_d',
        'question3', 'option3_a', 'option3_b', 'option3_c', 'option3_d',
        'question4', 'option4_a', 'option4_b', 'option4_c', 'option4_d',
        'question5', 'option5_a', 'option5_b', 'option5_c', 'option5_d'
    ];
}
