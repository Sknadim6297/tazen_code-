<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_box_id',
        'service_id',
        'name',
        'image',
        'status'
    ];

    /**
     * Get the main category that owns the subcategory.
     */
    public function categoryBox()
    {
        return $this->belongsTo(CategoryBox::class, 'category_box_id');
    }

    /**
     * Get the service that the subcategory belongs to.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
