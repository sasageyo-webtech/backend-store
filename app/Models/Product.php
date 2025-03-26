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

//    public function getImagePaths(): array
//    {
//        // เช็คว่ามี image_paths หรือไม่
//        if (!$this->image_paths) {
//            return [];
//        }
//
//        // แปลง path ของแต่ละภาพให้เป็น URL ที่สามารถเข้าถึงได้
//        return collect($this->image_paths)->map(function ($path) {
//            return Storage::url($path); // การใช้ Storage::url จะคืนค่า URL ที่สามารถเข้าถึงได้
//        })->all();
//    }

//    public function getImageUrls(): array
//    {
//        // เช็คว่ามี image_paths หรือไม่
//        if (!$this->image_paths) {
//            return [];
//        }
//
//        // แปลง path ของแต่ละภาพให้เป็น URL ที่สามารถเข้าถึงได้
//        return collect($this->getImagePaths())->map(function ($path) {
//            return  env('APP_URL', 'http://localhost')  . $path; // การใช้ Storage::url จะคืนค่า URL ที่สามารถเข้าถึงได้
//        })->all();
//    }
}
