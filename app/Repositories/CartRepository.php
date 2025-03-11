<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Repositories\Traits\SimpleCRUD;

class CartRepository
{
    use SimpleCRUD;
    private string $model = Cart::class;

    public function getByCustomerId(int $id)
    {
        return $this->model::where("customer_id", $id)->with("product")->get();
    }
}
