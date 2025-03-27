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
        $name = [
            'Mizumi',
            'Orental Princess',
            'Rojukiss',
            'Srichand',
            'Mistine',
            'Hydrating Night Cream',
            'Ultra Repair Face Cream',
            'Anti-Aging Collagen Cream',
            'Daily Moisture Lotion',
            'Hydrating Body Lotion',
            'Lavender Relaxing Lotion',
            'Micellar Water Cleanser',
            'Oil-Free Eye Makeup Remover',
            'Deep Cleansing Balm',
            'Gentle Foaming Cleanser',
            'Deep Pore Cleansing Gel',
            'Charcoal Detox Cleanser',
            'Hydrating Rose Toner',
            'Pore-Tightening Witch Hazel Toner',
            ' Brightening Vitamin C Toner',
            'Hydrating Essence Mist',
            'Fermented Rice Water Essence',
            'Snail Mucin Repair Essence'
        ];

//        $image_paths = collect(range(1, rand(2, 3)))->map(fn () => $this->getRandomImagePath())->all();

        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'name' => $this->faker->randomElement($name),
            'description' => $this->faker->realText(),
            'price' => $this->faker->numberBetween(50, 1000),
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
