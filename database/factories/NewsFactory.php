<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'title'        => $title,
            'slug'         => \Illuminate\Support\Str::slug($title),
            'excerpt'      => fake()->paragraph(2),
            'body'         => fake()->paragraphs(5, true),
            'is_published' => fake()->boolean(70),
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'sort_order'   => fake()->numberBetween(0, 100),
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'is_published' => true,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }
}
