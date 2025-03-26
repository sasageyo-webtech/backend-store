<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ImageProduct extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'product_id',
        'image_path',
    ];

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function getImagePath()  {
        return  Storage::url($this->image_path);
    }

    public function getImageUrl()  {
        return env('APP_URL', 'http://localhost') . $this->getImagePath();
    }
}
