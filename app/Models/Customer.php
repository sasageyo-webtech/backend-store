<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'user_id',
    ];

    public function carts(): HasMany {
        return $this->hasMany(Cart::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
