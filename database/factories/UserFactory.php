<?php

namespace Database\Factories;

use App\Models\Enums\GenderType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $username = fake()->unique()->username();

        return [
            'username' => $username,
            'email' => fake()->unique()->safeEmail(),
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'gender' => fake()->randomElement([GenderType::MALE, GenderType::FEMALE, GenderType::FEMALE, GenderType::OTHER]),
            'citizen_code' => $this->faker->unique()->numerify('#############'),
            'birthdate' => $this->faker->date('Y-m-d'),
            'phone_number' => fake()->unique()->phoneNumber(),
            'image_path' => fake()->imageUrl(200, 200, 'users', true, $username),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
