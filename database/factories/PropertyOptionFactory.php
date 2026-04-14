<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyOptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'property_id' => 1,
            'value'       => fake()->word(),
            'color_hex'   => null,
        ];
    }
}
