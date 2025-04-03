<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'description',
        'price',
        'stock',
        'rating',
        'accessibility',
    ];

    protected $casts = [
        'image_paths' => 'array',
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo {
        return $this->belongsTo(Brand::class);
    }

    public function carts(): HasMany {
        return $this->hasMany(Cart::class);
    }

    public function order_products(): HasMany {
        return $this->hasMany(OrderProduct::class);
    }

    public function images(): HasMany {
        return $this->hasMany(ImageProduct::class);
    }

    public function reviews(): HasMany {
        return $this->hasMany(Review::class);
    }
}
