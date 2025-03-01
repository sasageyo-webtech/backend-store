<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Traits\SimpleCRUD;

class CategoryRepository
{
    use SimpleCRUD;
    private string $model = Category::class;
}
