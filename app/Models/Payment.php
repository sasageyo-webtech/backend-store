<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'method',
        'image_receipt_path'
    ];

    public function order(): BelongsTo {
        return $this->belongsTo(Order::class);
    }

    public function getImagePath()  {
        return  Storage::url($this->image_receipt_path);
    }

    public function getImageUrl()  {
        return env('APP_URL', 'http://localhost') . $this->getImagePath();
    }
}
