<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(fake()->numberBetween(1, 3), true);
        $name = ucwords($name);
        return [
            'name'        => $name,
            'slug'        => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 9999),
            'description' => fake()->optional()->sentence(),
            'image'       => null,
            'parent_id'   => null,
            'status'      => fake()->boolean(90),
        ];
    }
}
