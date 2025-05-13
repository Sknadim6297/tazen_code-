<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalOtherInformation extends Model
{
    use HasFactory;

    protected $table = 'professional_other_informations'; 

    protected $fillable = [
        'professional_id',
        'sub_heading',
        'requested_service',
        'price',
        'statement',
        'specializations',
        'education',
    ];
    protected $casts = [
        'requested_service' => 'array',
        'price' => 'array',
        'specializations' => 'array',
        'education' => 'array',
    ];
        
}
