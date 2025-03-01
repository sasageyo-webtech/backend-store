<?php

namespace Database\Seeders;

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
            Product::factory()->count($limit)->create();
        }
    }
}
