<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'address_customer_id',
        'payment_id',
        'total_price',
        'status',
    ];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function order_products(): HasMany {
        return $this->hasMany(OrderProduct::class);
    }

    public function payment(): HasOne {
        return $this->hasOne(Payment::class);
    }

    public function address_customer(): BelongsTo {
        return $this->belongsTo(AddressCustomer::class);
    }
}
