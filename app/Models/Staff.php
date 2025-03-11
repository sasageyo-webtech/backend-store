<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Staff extends Model
{
    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
