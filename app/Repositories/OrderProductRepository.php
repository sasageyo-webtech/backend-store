<?php

namespace App\Repositories;

use App\Models\OrderProduct;
use App\Repositories\Traits\SimpleCRUD;

class OrderProductRepository
{
    use SimpleCRUD;
    private string $model = OrderProduct::class;
}
