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

//        $image_paths = collect(range(1, rand(2, 3)))->map(fn () => $this->getRandomImagePath())->all();

        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'name' => $name,
            'description' => $this->faker->realText(),
            'price' => $this->faker->numberBetween(500, 10000),
            'stock' => $this->faker->numberBetween(0, 100),
            'rating' => $this->faker->numberBetween(0, 5),
            'accessibility' => $this->faker->randomElement([ProductAccessibility::PUBLIC, ProductAccessibility::PRIVATE]),
        ];
    }

//    protected function getRandomImagePath(): string
//    {
//        // โฟลเดอร์ที่เก็บรูปภาพ
//        $imagesFolder = 'products';
//
//        // ดึงรายชื่อไฟล์ทั้งหมดในโฟลเดอร์
//        $files = Storage::disk('public')->files($imagesFolder);
//
//        // เลือกไฟล์ภาพแบบสุ่ม
//        $randomFile = $files[array_rand($files)];
//
//        // คืนค่า path ของภาพที่เลือก
//        return $randomFile;
//    }
}
