<?php

namespace Database\Factories;

use App\Models\CatalogItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CatalogItem>
 */
class CatalogItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'catalog_category_id' => null,
            'title'               => fake()->sentence(3),
            'subtitle'            => fake()->sentence(5),
            'description'         => fake()->paragraph(),
            'reference'           => strtoupper(fake()->bothify('REF-####-??')),
            'specifications'      => fake()->paragraph(),
            'sort_order'          => fake()->numberBetween(0, 100),
            'is_featured'         => false,
            'is_active'           => true,
        ];
    }
}
