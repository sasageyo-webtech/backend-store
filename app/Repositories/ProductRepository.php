<?php

namespace App\Repositories;

use App\Models\OrderProduct;
use App\Models\Product;
use App\Repositories\Traits\SimpleCRUD;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository
{
    use SimpleCRUD;
    private string $model = Product::class;

    public function filterByName(string $name, int $limit = 10): LengthAwarePaginator
    {
        return $this->model::whereRaw('LOWER(name) LIKE ?', ["%" . strtolower($name) . "%"])->paginate($limit);
    }

    public function getByCategoryId(int $categoryId, int $limit = 10): LengthAwarePaginator {
        return $this->model::where('category_id', $categoryId)->paginate($limit);
    }

    public function getByBrandId(int $brandId, int $limit = 10): LengthAwarePaginator {
        return $this->model::where('brand_id', $brandId)->paginate($limit);
    }

    public function isUsedInOrder(int $product_id): bool
    {
        // ตัวอย่างการตรวจสอบว่า product_id นี้ถูกใช้ในคำสั่งซื้อหรือไม่
        return OrderProduct::where('product_id', $product_id)->exists();
    }

}
