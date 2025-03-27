<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ImageProduct>
 */
class ImageProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => 0,
            'image_path' => $this->getRandomImagePath(),
        ];
    }

        protected function getRandomImagePath(): string
        {
            // โฟลเดอร์ที่เก็บรูปภาพ
            $imagesFolder = 'products';

            // ดึงรายชื่อไฟล์ทั้งหมดในโฟลเดอร์
            $files = Storage::disk('public')->files($imagesFolder);

            // เลือกไฟล์ภาพแบบสุ่ม
            $randomFile = $files[array_rand($files)];

            // คืนค่า path ของภาพที่เลือก
            return $randomFile;
        }
}
