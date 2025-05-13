<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'notes',
        'city',
        'state',
        'zip_code',
        'profile_image',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
