<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'route_name',
        'icon',
        'parent_id',
        'order'
    ];

    /**
     * Get the parent menu item.
     */
    public function parent()
    {
        return $this->belongsTo(AdminMenu::class, 'parent_id');
    }

    /**
     * Get the child menu items.
     */
    public function children()
    {
        return $this->hasMany(AdminMenu::class, 'parent_id')->orderBy('order');
    }

    /**
     * Get the admins who have permission to access this menu.
     */
    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_menu_permissions');
    }
}