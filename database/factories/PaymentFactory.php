<?php

namespace Database\Factories;

use App\Models\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "order_id" => 0,
            "image_receipt_path" => $this->getRandomImagePath(),
            "method" => PaymentMethod::BANK_TRANSFER,
            "amount" => 1000,
        ];
    }

    protected function getRandomImagePath(): string
    {
        // โฟลเดอร์ที่เก็บรูปภาพ
        $imagesFolder = 'receipts';

        // ดึงรายชื่อไฟล์ทั้งหมดในโฟลเดอร์
        $files = Storage::disk('public')->files($imagesFolder);

        // เลือกไฟล์ภาพแบบสุ่ม
        $randomFile = $files[array_rand($files)];

        // คืนค่า path ของภาพที่เลือก
        return $randomFile;
    }
}
