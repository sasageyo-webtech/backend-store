<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Enums\ProductAccessibility;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

//        // สร้างและบันทึกรูปลง storage แล้วใช้ path
//        $image_paths = collect(range(1, rand(2, 5)))->map(fn () =>
//            "https://picsum.photos/seed/" . uniqid() . "/640/480"
//        )->all();

        $image_paths = collect(range(1, rand(1, 2)))->map(fn () => $this->createFakeImage(now()))->all();

        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'name' => $name,
            'description' => $this->faker->realText(),
            'price' => $this->faker->numberBetween(500, 10000),
            'stock' => $this->faker->numberBetween(0, 100),
            'image_paths' => $image_paths,
            'rating' => $this->faker->numberBetween(0, 5),
            'accessibility' => $this->faker->randomElement([ProductAccessibility::PUBLIC, ProductAccessibility::PRIVATE]),
        ];
    }

    protected function createFakeImage(string $name): string
    {
        // สร้างภาพโดยใช้ URL ของ picsum
        $imageContent = file_get_contents('https://picsum.photos/640/480');
        $imageName = Str::random(10) . $name . '.jpg';

        // บันทึกภาพลงใน storage/public/products
        Storage::disk('public')->put('products/' . $imageName, $imageContent);

        // คืนค่า path ของภาพที่เก็บใน storage
        return 'products/' . $imageName;
    }
}
