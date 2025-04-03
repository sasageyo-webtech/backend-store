<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brand_names = [
            'Mizumi',
            'Orental Princess',
            'Rojukiss',
            'Srichand',
            'Mistine'
        ];
        return [
            'name' => $this->faker->randomElement($brand_names),
        ];
    }
}
