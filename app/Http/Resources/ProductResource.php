<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => new CategoryResource($this->whenLoaded('category')), // โหลดความสัมพันธ์ category
            'brand' => new BrandResource($this->whenLoaded('brand')), // โหลด brand
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image_paths' => collect($this->image_paths)->map(fn ($path) => Storage::url($path))->all(), // ทำให้เป็น URL
            'rating' => $this->rating,
            'accessibility' => $this->accessibility,
        ];
    }

    protected function getImageUrls()
    {
        // เช็คว่ามี image_paths หรือไม่
        if (!$this->image_paths) {
            return [];
        }

        // แปลง path ของแต่ละภาพให้เป็น URL ที่สามารถเข้าถึงได้
        return collect($this->image_paths)->map(function ($path) {
            return Storage::url($path); // การใช้ Storage::url จะคืนค่า URL ที่สามารถเข้าถึงได้
        })->all();
    }
}
