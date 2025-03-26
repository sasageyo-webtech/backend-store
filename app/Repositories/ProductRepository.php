<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Traits\SimpleCRUD;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    use SimpleCRUD;
    private string $model = Product::class;

    public function filterByName(string $name): Collection
    {
        return $this->model::where('name', 'LIKE', "%$name%")->get();
    }

    public function getByCategoryId(int $categoryId): Collection {
        return $this->model::where('category_id', $categoryId)->get();
    }

    public function getByBrandId(int $brandId): Collection {
        return $this->model::where('brand_id', $brandId)->get();
    }
}
