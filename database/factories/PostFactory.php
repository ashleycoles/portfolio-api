<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'slug' => fake()->word(),
            'content' => fake()->paragraphs(3, true),
            'excerpt' => fake()->sentence(6),
            'featuredImage' => 'https://placehold.co/600x400/EEE/31343C',
        ];
    }
}
