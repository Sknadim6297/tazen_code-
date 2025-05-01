<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Whychoose extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_heading',
        'section_sub_heading',
        'card1_mini_heading',
        'card1_heading',
        'card1_icon',
        'card1_description',
        'card2_mini_heading',
        'card2_heading',
        'card2_icon',
        'card2_description',
        'card3_mini_heading',
        'card3_heading',
        'card3_icon',
        'card3_description',
        'card4_mini_heading',
        'card4_heading',
        'card4_icon',
        'card4_description',
        'card5_mini_heading',
        'card5_heading',
        'card5_icon',
        'card5_description',
        'card6_mini_heading',
        'card6_heading',
        'card6_icon',
        'card6_description',
    ];
}
