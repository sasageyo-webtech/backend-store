<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'cart_id' => $this->id,
            'customer_id' => $this->customer->id,
            'product' => [
                'product_id' => $this->product->id,
                'image_paths' => $this->product->images->first()->getImageUrl(),
                'name' => $this->product->name,
                'price' => $this->product->price,
                'stock' => $this->product->stock,
            ],
            'quantity' => $this->quantity, // จำนวนสินค้าที่อยู่ในตะกร้า
            'total_price' => $this->quantity * $this->product->price,
        ];
    }
}
