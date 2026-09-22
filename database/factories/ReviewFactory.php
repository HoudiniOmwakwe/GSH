<?php

namespace Database\Factories;

use App\Models\Casino;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ratings = [
            fake()->randomFloat(1, 2, 5),
            fake()->randomFloat(1, 2, 5),
            fake()->randomFloat(1, 2, 5),
            fake()->randomFloat(1, 2, 5),
        ];

        $title = fake()->unique()->sentence(6);

        return [
            'casino_id' => Casino::factory(),
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => str($title)->slug(),
            'body' => fake()->paragraphs(6, true),
            'pros' => fake()->sentences(3),
            'cons' => fake()->sentences(2),
            'rating_payout' => $ratings[0],
            'rating_games' => $ratings[1],
            'rating_support' => $ratings[2],
            'rating_bonuses' => $ratings[3],
            'rating_overall' => round(array_sum($ratings) / count($ratings), 1),
            'status' => fake()->randomElement(['draft', 'published', 'published']),
            'published_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
