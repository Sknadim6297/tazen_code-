<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    /**
     * Get the menus that this admin has permission to access.
     */
    public function menus()
    {
        return $this->belongsToMany(AdminMenu::class, 'admin_menu_permissions');
    }

    /**
     * Check if admin has access to a specific menu by name
     */
    public function hasMenuAccess($menuName)
    {
        // Super admin always has access to all menus
        if ($this->role === 'super_admin') {
            return true;
        }

        return $this->menus()->where('name', $menuName)->exists();
    }

    /**
     * Check if admin has access to a specific menu by ID
     */
    public function hasMenuAccessById($menuId)
    {
        // Super admin always has access to all menus
        if ($this->role === 'super_admin') {
            return true;
        }

        return $this->menus()->where('id', $menuId)->exists();
    }

    /**
     * Check if the admin is a super admin
     */
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }
}
