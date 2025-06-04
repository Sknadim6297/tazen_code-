<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Professional extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'professionals';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'professional_id', 'id');
    }

    public function professionalServices()
    {
        return $this->hasMany(ProfessionalService::class);
    }
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }
    public function professionalRejection()
    {
        return $this->hasMany(ProfessionalRejection::class);
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ProfessionalResetPassword($token));
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}