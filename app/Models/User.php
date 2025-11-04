<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'email_verified',
        'registration_completed',
        'registration_status',
        'password_set_at',
        'customer_onboarding_completed_at',
        'professional_onboarding_completed_at',
        'onboarding_data',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password_set_at' => 'datetime',
        'email_verified' => 'boolean',
        'registration_completed' => 'boolean',
        'customer_onboarding_completed_at' => 'datetime',
        'professional_onboarding_completed_at' => 'datetime',
        'onboarding_data' => 'array',
    ];
    public function customerProfile()
    {
        return $this->hasOne(CustomerProfile::class);
    }
    
    /**
     * Hash password when setting it
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
    
    public function bookings()
    {
        return $this->hasMany(EventBooking::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function additionalServices()
    {
        return $this->hasMany(AdditionalService::class);
    }

    // Add a method to check if user has already reviewed a professional
    public function hasReviewedProfessional($professionalId)
    {
        return $this->reviews()->where('professional_id', $professionalId)->exists();
    }
}
