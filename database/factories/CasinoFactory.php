<?php

namespace Database\Factories;

use App\Models\Casino;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Casino>
 */
class CasinoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'name' => $name,
            'slug' => str($name)->slug(),
            'type' => fake()->randomElement(['casino', 'sportsbook', 'crypto-exchange']),
            'summary' => fake()->sentence(20),
            'description' => fake()->paragraphs(4, true),
            'license_info' => fake()->randomElement(['Curacao eGaming', 'Malta Gaming Authority', 'UK Gambling Commission']),
            'established_year' => fake()->numberBetween(2005, 2025),
            'website_url' => fake()->url(),
            'affiliate_link' => fake()->url(),
            'bonus_summary' => fake()->sentence(15),
            'status' => fake()->randomElement(['draft', 'published', 'published']),
            'is_featured' => fake()->boolean(20),
            'ordering' => fake()->numberBetween(0, 100),
        ];
    }
}
