<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Color', 'Size', 'Material', 'Weight', 'Style',
                'Finish', 'Pattern', 'Fit', 'Length', 'Width',
            ]),
            'type' => fake()->randomElement(['select', 'color', 'text']),
        ];
    }
}
