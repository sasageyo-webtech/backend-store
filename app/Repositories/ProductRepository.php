<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Traits\SimpleCRUD;

class ProductRepository
{
    use SimpleCRUD;
    private string $model = Product::class;
}
