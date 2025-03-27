<?php

namespace App\Http\Resources;

use App\Models\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'user_id' => $this->id,
            'customer_id' => $this->customer?->id,
            'staff_id' => $this->staff?->id,
            'username' => $this->username,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'gender' => $this->gender,
            'citizen_code' => $this->citizen_code,
            'birthdate' => $this->birthdate,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'image_path' => $this->image_path,
            'role' => $this->role,
            'token' => $this->createToken('token')->plainTextToken,
        ];

        return $data;
    }
}
