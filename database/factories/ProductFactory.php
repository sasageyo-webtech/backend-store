<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Enums\ProductAccessibility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name();
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'name' => $name,
            'description' => $this->faker->realText(),
            'price' => $this->faker->numberBetween(500, 10000),
            'stock' => $this->faker->numberBetween(0, 100),
            'image_paths' => json_encode([
                $this->faker->imageUrl(width: 200, height: 200, category: 'products', randomize: true, word: $name),
                $this->faker->imageUrl(200, 200, 'products', true, $name),
            ]),
            'rating' => $this->faker->numberBetween(0, 5),
            'accessibility' => $this->faker->randomElement([ProductAccessibility::PUBLIC, ProductAccessibility::PRIVATE]),
        ];
    }
}
