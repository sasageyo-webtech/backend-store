<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =  ['customer_id', 'product_id', 'quantity'];

    public function customer() : belongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function product() : belongsTo {
        return $this->belongsTo(Product::class);
    }
}
