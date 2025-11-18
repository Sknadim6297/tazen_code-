<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'career_id',
        'full_name',
        'email',
        'phone_country',
        'phone_number',
        'compensation_expectation',
        'why_perfect_fit',
        'cv_resume',
        'cover_letter_file',
        'cover_letter_text',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function career()
    {
        return $this->belongsTo(Career::class);
    }
}
