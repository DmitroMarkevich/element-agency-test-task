<?php

namespace Database\Factories;

use App\Enums\PersonType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'type' => fake()->randomElement(
                array_map(fn (PersonType $type) => $type->value, PersonType::cases())
            ),
            'photo' => null,
        ];
    }
}
