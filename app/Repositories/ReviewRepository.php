<?php

namespace App\Repositories;

use App\Models\Review;
use App\Repositories\Traits\SimpleCRUD;
use Illuminate\Pagination\LengthAwarePaginator;

class ReviewRepository
{
    use SimpleCRUD;
    private string $model = Review::class;

    public function getByProductId(int $product_id, int $limit = 10): LengthAwarePaginator {
        return $this->model::where('product_id', $product_id)->paginate($limit);
    }
}
