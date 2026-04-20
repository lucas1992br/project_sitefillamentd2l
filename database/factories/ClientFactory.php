<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'         => fake()->company(),
            'industry'     => fake()->optional()->randomElement([
                'Automotive',
                'Oil & Gas',
                'Aerospace',
                'Mining',
                'Food & Beverage',
                'Pharmaceutical',
            ]),
            'website'      => fake()->optional()->url(),
            'testimonial'  => fake()->optional(0.6)->paragraph(),
            'contact_name' => fake()->optional()->name(),
            'contact_role' => fake()->optional()->randomElement([
                'Procurement Manager',
                'Engineering Director',
                'Quality Manager',
                'Supply Chain Coordinator',
            ]),
            'is_featured'  => fake()->boolean(25),
            'sort_order'   => fake()->numberBetween(0, 20),
            'is_active'    => true,
        ];
    }

    public function featured(): static
    {
        return $this->state([
            'is_featured' => true,
            'is_active'   => true,
            'testimonial' => fake()->paragraph(),
            'contact_name' => fake()->name(),
            'contact_role' => fake()->randomElement([
                'Procurement Manager',
                'Engineering Director',
                'Quality Manager',
            ]),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
