<?php

namespace Database\Factories;

use App\Models\ComparisonTable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ComparisonTable>
 */
class ComparisonTableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->sentence(4);

        return [
            'name' => $name,
            'slug' => str($name)->slug(),
            'description' => fake()->sentence(15),
            'status' => fake()->randomElement(['draft', 'published']),
        ];
    }
}
