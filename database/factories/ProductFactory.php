<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name  = fake()->unique()->words(fake()->numberBetween(2, 4), true);
        $name  = ucwords($name);
        $price = fake()->randomFloat(2, 9.99, 999.99);

        return [
            'parent_id'      => null,
            'name'           => $name,
            'slug'           => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 99999),
            'description'    => fake()->paragraphs(2, true),
            'price'          => $price,
            'compare_price'  => fake()->boolean(40) ? round($price * fake()->randomFloat(2, 1.1, 1.5), 2) : null,
            'stock'          => fake()->numberBetween(0, 200),
            'sku'            => strtoupper(fake()->unique()->bothify('SKU-####-??')),
            'product_number' => strtoupper(fake()->unique()->bothify('PN-######')),
            'ean'            => fake()->optional()->ean13(),
            'image'          => null,
            'brand_id'       => null,
            'active'         => fake()->boolean(85),
        ];
    }
}
