<?php

namespace Database\Factories;

use App\Models\PortfolioItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PortfolioItem>
 */
class PortfolioItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'       => fake()->sentence(4, false),
            'subtitle'    => fake()->optional()->sentence(3, false),
            'description' => fake()->optional()->paragraph(),
            'category'    => fake()->randomElement([
                'CNC Turning',
                'CNC Milling',
                'Welding',
                'Finishing',
                'Assembly',
            ]),
            'material'    => fake()->optional()->randomElement([
                'AISI 304 Stainless Steel',
                'AISI 1020 Carbon Steel',
                'Aluminium 6061',
                'Titanium Grade 5',
                'Inconel 625',
            ]),
            'tolerance'   => fake()->optional()->randomElement([
                '±0.01 mm',
                '±0.05 mm',
                '±0.1 mm',
                'H7/h6',
            ]),
            'client_name' => fake()->optional()->company(),
            'sort_order'  => fake()->numberBetween(0, 20),
            'is_featured' => fake()->boolean(30),
            'is_active'   => true,
        ];
    }

    public function featured(): static
    {
        return $this->state(['is_featured' => true, 'is_active' => true]);
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
