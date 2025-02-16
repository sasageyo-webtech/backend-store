<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        "customer_id",
        'address_customer_id',
        'status',
    ];
}
