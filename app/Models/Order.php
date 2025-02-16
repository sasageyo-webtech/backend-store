<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'shipment_id',
        'payment_id',
        'total_price',
        'status',
    ];
}
