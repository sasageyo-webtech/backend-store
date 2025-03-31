<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "review_id" => $this->id,
            "customer_id" => $this->customer->id,
            "product_id" => $this->product->id,
            "comment" => $this->comment,
            "rating" => $this->rating,
            "created_at" => $this->created_at,
        ];
    }
}
