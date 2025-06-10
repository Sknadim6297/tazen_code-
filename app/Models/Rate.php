<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'session_type',
        'num_sessions',
        'rate_per_session',
        'final_rate',
    ];
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}
