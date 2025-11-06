<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBox extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
        'order'
    ];

    /**
     * Get the subcategories for the main category.
     */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_box_id');
    }
}
