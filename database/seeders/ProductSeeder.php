<?php

namespace Database\Seeders;

use App\Models\ImageProduct;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $limit = 20;
        $exits = Product::count();
        if ($limit > $exits) {
            for ($i = 1; $i <= $limit; $i++) {
                $product = Product::factory()->create();
                ImageProduct::factory()->create([
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
