<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return [
            'title'       => ucwords($title),
            'subtitle'    => fake()->optional()->sentence(4),
            'description' => fake()->paragraphs(2, true),
            'icon'        => fake()->randomElement([
                'heroicon-o-wrench-screwdriver',
                'heroicon-o-squares-2x2',
                'heroicon-o-fire',
                'heroicon-o-shield-check',
                'heroicon-o-cog-6-tooth',
            ]),
            'slug'        => Str::slug($title),
            'sort_order'  => fake()->numberBetween(0, 10),
            'is_active'   => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
