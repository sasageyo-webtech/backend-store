<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => 0,
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'rating' => $this->faker->numberBetween(0, 5),
            'comment' => $this->faker->realText(),
        ];
    }
}
