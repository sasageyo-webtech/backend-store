<?php

namespace Database\Factories;

use App\Models\Enums\GenderType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->randomElement([GenderType::MALE, GenderType::FEMALE, GenderType::OTHER]);

        return [
            'user_id' => User::factory()->create()->id,
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'gender' => $gender,
            'birthdate' => $this->faker->date('Y-m-d'),
            'citizen_code' => $this->faker->unique()->numerify('#############'),
        ];
    }
}
