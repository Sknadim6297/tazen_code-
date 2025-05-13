<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalRejection extends Model
{
    use HasFactory;
    protected $fillable = ['professional_id', 'reason'];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
    public function profile()
    {
        return $this->hasOne(Profile::class, 'professional_id', 'professional_id');
    }
}
