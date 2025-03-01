<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\Traits\SimpleCRUD;

class BrandRepository
{
    use SimpleCRUD;
    private string $model = Brand::class;
}
