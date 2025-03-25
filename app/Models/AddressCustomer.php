<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressCustomer extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'customer_id',
        'name',
        'phone_number',
        'house_number',
        'building',
        'street',
        'sub_district',
        'district',
        'province',
        'postal_code',
        'country',
        'detail_address',
    ];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }
}
