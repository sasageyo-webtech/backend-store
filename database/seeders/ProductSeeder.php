<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\ImageProduct;
use App\Models\Product;
use App\Models\Review;
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
        $limit = 100;
        $exits = Product::count();
        if ($limit > $exits) {
            for ($i = 1; $i <= $limit; $i++) {
                $product = Product::factory()->create();

                //random images for product
                $numbs_image = rand(3, 5);
                for($j = 1; $j <= $numbs_image; $j++) {
                    ImageProduct::factory()->create([
                        'product_id' => $product->id,
                    ]);
                }

                // random review for product
                $total_rating = 0;
                $numbs_reviews = rand(3, 6);
                for($j = 1; $j <= $numbs_reviews; $j++) {
                    $review = Review::factory()->create([
                        'product_id' => $product->id,
                        'customer_id' => Customer::inRandomOrder()->first()->id,
                    ]);
                    $total_rating += $review->rating;
                }
                // ประมวลผล rating ให้ product
                $product->update([
                    "rating" => $total_rating/$numbs_reviews,
                ]);

            }
        }
    }
}
