<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $this->id,
            'customer_id' => $this->customer_id,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'payment' => [
                'payment_id' => $this->payment->id,
                'amount' => $this->payment->amount,
                'method' => $this->payment->method,
                'image_receipt_path' => $this->payment->image_receipt_path,
            ],
            'products' => $this->order_products->map(function ($order_product) {
                $product = $order_product->product;
                return [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $order_product->quantity,
                    'total_price' => $order_product->total_price,
                ];
            }),
        ];
    }
}
