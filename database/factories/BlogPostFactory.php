<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(6);

        return [
            'blog_category_id' => BlogCategory::factory(),
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => str($title)->slug(),
            'excerpt' => fake()->sentence(20),
            'body' => fake()->paragraphs(8, true),
            'status' => fake()->randomElement(['draft', 'published', 'published']),
            'published_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
