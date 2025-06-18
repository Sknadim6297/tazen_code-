<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMenuPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'admin_menu_id'
    ];
}