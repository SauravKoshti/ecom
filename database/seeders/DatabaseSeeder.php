<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use App\Models\PropertyOption;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Call seeders ────────────────────────────────────────
        $this->call([
            UserSeeder::class,
        ]);

        // Get existing users for product relationships

        // ── Brands (15) ─────────────────────────────────────────
        $brands = Brand::factory(15)->create();

        // ── Categories (10 parent + 10 child) ───────────────────
        $parents = Category::factory(10)->create();

        $parents->each(function ($parent) {
            Category::factory(fake()->numberBetween(1, 2))->create([
                'parent_id' => $parent->id,
            ]);
        });

        $allCategories = Category::all();

        // ── Properties with options ──────────────────────────────
        $propertyData = [
            ['name' => 'Color',    'type' => 'color',  'options' => [
                ['value' => 'Red',    'color_hex' => '#ef4444'],
                ['value' => 'Blue',   'color_hex' => '#3b82f6'],
                ['value' => 'Green',  'color_hex' => '#22c55e'],
                ['value' => 'Black',  'color_hex' => '#000000'],
                ['value' => 'White',  'color_hex' => '#ffffff'],
                ['value' => 'Yellow', 'color_hex' => '#eab308'],
            ]],
            ['name' => 'Size', 'type' => 'select', 'options' => [
                ['value' => 'XS'],  ['value' => 'S'],
                ['value' => 'M'],   ['value' => 'L'],
                ['value' => 'XL'],  ['value' => 'XXL'],
            ]],
            ['name' => 'Material', 'type' => 'select', 'options' => [
                ['value' => 'Cotton'],  ['value' => 'Polyester'],
                ['value' => 'Leather'], ['value' => 'Wool'],
                ['value' => 'Silk'],
            ]],
            ['name' => 'Weight', 'type' => 'text', 'options' => [
                ['value' => '100g'], ['value' => '250g'],
                ['value' => '500g'], ['value' => '1kg'],
            ]],
            ['name' => 'Style', 'type' => 'select', 'options' => [
                ['value' => 'Casual'],  ['value' => 'Formal'],
                ['value' => 'Sport'],   ['value' => 'Classic'],
            ]],
        ];

        $allOptions = collect();

        foreach ($propertyData as $data) {
            $property = Property::create([
                'name' => $data['name'],
                'type' => $data['type'],
            ]);

            foreach ($data['options'] as $opt) {
                $allOptions->push(PropertyOption::create([
                    'property_id' => $property->id,
                    'value'       => $opt['value'],
                    'color_hex'   => $opt['color_hex'] ?? null,
                ]));
            }
        }

        // ── Products (50) ────────────────────────────────────────
        Product::factory(50)->create([
            'brand_id' => fn () => $brands->random()->id,
        ])->each(function ($product) use ($allCategories, $allOptions) {
            // attach 1–3 categories
            $product->categories()->attach(
                $allCategories->random(fake()->numberBetween(1, 3))->pluck('id')
            );

            // attach 2–5 property options
            $product->propertyOptions()->attach(
                $allOptions->random(fake()->numberBetween(2, 5))->pluck('id')
            );
        });
    }
}
