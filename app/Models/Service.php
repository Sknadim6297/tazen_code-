<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'status'];

    public function detail()
    {
        return $this->hasOne(ServiceDetails::class, 'service_id');
    }
}
