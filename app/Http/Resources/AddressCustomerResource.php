<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressCustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customer_address_id' => $this->id,
            'customer_id' => $this->customer->id,
            'name' => $this->name, // ชื่อผู้รับ
            'phone_number' => $this->phone_number, // เบอร์โทรผู้รับ
            'house_number' => $this->house_number, // บ้านเลขที่
            'building' => $this->building, // ห้อง อาคาร ชั้น
            'street' => $this->street, // ถนน
            'sub_district' => $this->sub_district, // แขวง
            'district' => $this->district, // เขต
            'province' => $this->province, // จังหวัด
            'country' => $this->country, // ประเทศ
            'postal_code' => $this->postal_code, // รหัสไปรษณีย์
            'detail_address' => $this->detail_address, // รายละเอียดที่อยู่
        ];
    }

}
