<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'gender',
        'birthdate',
        'citizen_code',
        'cart',
        'product_likes',
    ];

    protected $casts = [
        'cart' => 'array',
        'product_likes' => 'array',
    ];
}
