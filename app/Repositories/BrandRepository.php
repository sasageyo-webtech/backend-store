<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\Traits\SimpleCRUD;

class BrandRepository
{
    use SimpleCRUD;
    private string $model = Brand::class;

    public function findByName(string $name): ?Brand {
        return $this->model::where('name', $name)->first();
    }
}
