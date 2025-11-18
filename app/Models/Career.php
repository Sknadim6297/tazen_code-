<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'location',
        'job_type',
        'department',
        'description',
        'who_are_we',
        'expectation_of_role',
        'accounts_payable_payroll',
        'accounts_receivable',
        'financial_reporting',
        'requirements',
        'what_we_offer',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}
