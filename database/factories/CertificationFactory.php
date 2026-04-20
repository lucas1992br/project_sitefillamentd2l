<?php

namespace Database\Factories;

use App\Models\Certification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Certification>
 */
class CertificationFactory extends Factory
{
    public function definition(): array
    {
        $issuedAt = fake()->dateTimeBetween('-5 years', '-1 year');

        return [
            'name'               => fake()->randomElement([
                'ISO 9001:2015',
                'ISO 14001:2015',
                'OHSAS 18001',
                'AS9100D',
                'IATF 16949',
            ]),
            'issuer'             => fake()->randomElement([
                'Bureau Veritas',
                'DNV GL',
                'SGS',
                'TÜV Rheinland',
                'Lloyd\'s Register',
            ]),
            'certificate_number' => strtoupper(fake()->bothify('BR-#####-20##')),
            'issued_at'          => $issuedAt,
            'expires_at'         => fake()->optional(0.8)->dateTimeBetween('+6 months', '+3 years'),
            'description'        => fake()->optional()->sentence(),
            'sort_order'         => fake()->numberBetween(0, 10),
            'is_active'          => true,
        ];
    }

    public function expired(): static
    {
        return $this->state([
            'expires_at' => fake()->dateTimeBetween('-2 years', '-1 day'),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
