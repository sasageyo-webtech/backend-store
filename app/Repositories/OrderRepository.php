<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Traits\SimpleCRUD;
use Illuminate\Database\Eloquent\Collection;


class OrderRepository
{
    use SimpleCRUD;
    private string $model = Order::class;

    public function getByCustomerId(int $customerId): Collection {
        return $this->model::where('customer_id', $customerId)->get();
    }
}
