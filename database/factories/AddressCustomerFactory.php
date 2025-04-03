<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AddressCustomer>
 */
class AddressCustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => 0,  // สร้าง customer อัตโนมัติ
            'name' => $this->faker->name,  // สุ่มชื่อ
            'phone_number' => $this->faker->phoneNumber,  // สุ่มหมายเลขโทรศัพท์
            'house_number' => $this->faker->buildingNumber,  // สุ่มบ้านเลขที่
            'building' => $this->faker->optional()->word,  // สุ่มอาคาร (บางกรณีไม่จำเป็น)
            'street' => $this->faker->streetName,  // สุ่มชื่อถนน
            'sub_district' => $this->faker->citySuffix,  // สุ่มแขวง
            'district' => $this->faker->city,  // สุ่มเขต
            'province' => $this->faker->state,  // สุ่มจังหวัด
            'country' => 'Thailand',  // ค่าเริ่มต้นเป็น Thailand
            'postal_code' => $this->faker->postcode,  // สุ่มรหัสไปรษณีย์
            'detail_address' => $this->faker->optional()->text,  // สุ่มรายละเอียดเพิ่มเติม
        ];
    }
}
