<?php

namespace App\Repositories;

use App\Models\ImageProduct;
use App\Repositories\Traits\SimpleCRUD;

class ImageProductRepository
{
    use SimpleCRUD;
    private string $model = ImageProduct::class;
}
