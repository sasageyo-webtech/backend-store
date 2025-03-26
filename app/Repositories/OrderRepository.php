<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Traits\SimpleCRUD;

class OrderRepository
{
    use SimpleCRUD;
    private string $model = Order::class;
}
