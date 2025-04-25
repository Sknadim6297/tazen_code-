<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'icon1', 'heading1', 'sub_heading1', 'description1',
        'icon2', 'heading2', 'sub_heading2', 'description2',
        'icon3', 'heading3', 'sub_heading3', 'description3',
    ];
}
