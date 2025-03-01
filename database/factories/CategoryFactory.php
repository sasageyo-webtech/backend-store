<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Cream',
            'Lotion',
            'Makeup remover',
            'Cleanser',
            'Toner',
            'Essence',
            'Serum',
            'Sunscreen',
            'Emulsion'
        ];

        return [
            'name' => $this->faker->randomElement($categories),
        ];
    }
}
