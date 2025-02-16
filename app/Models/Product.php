<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'stock',
        'image_paths',
        'rating',
        'likes',
        'accessibility',
    ];

    protected $casts = [
        'image_paths' => 'array',
    ];
}
