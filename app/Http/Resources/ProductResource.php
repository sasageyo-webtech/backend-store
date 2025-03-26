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
            'category' => new CategoryResource($this->category), // โหลดความสัมพันธ์ category
            'brand' => new BrandResource($this->brand), // โหลด brand
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image_paths' => $this->getImageUrls(), // ทำให้เป็น URL
            'rating' => $this->rating,
            'accessibility' => $this->accessibility,
        ];
    }
}
