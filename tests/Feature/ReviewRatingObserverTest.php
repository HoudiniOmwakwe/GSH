<?php

namespace Tests\Feature;

use App\Models\Casino;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewRatingObserverTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_published_review_updates_the_casinos_rating_avg(): void
    {
        $casino = Casino::factory()->create();

        Review::factory()->create([
            'casino_id' => $casino->id,
            'status' => 'published',
            'rating_payout' => 4,
            'rating_games' => 4,
            'rating_support' => 4,
            'rating_bonuses' => 4,
        ]);

        $this->assertEquals('4.00', $casino->fresh()->rating_avg);
    }

    public function test_updating_a_reviews_ratings_recalculates_the_casinos_rating_avg(): void
    {
        $casino = Casino::factory()->create();

        $review = Review::factory()->create([
            'casino_id' => $casino->id,
            'status' => 'published',
            'rating_payout' => 2,
            'rating_games' => 2,
            'rating_support' => 2,
            'rating_bonuses' => 2,
        ]);

        $this->assertEquals('2.00', $casino->fresh()->rating_avg);

        $review->update([
            'rating_payout' => 5,
            'rating_games' => 5,
            'rating_support' => 5,
            'rating_bonuses' => 5,
        ]);

        $this->assertEquals('5.00', $casino->fresh()->rating_avg);
    }

    public function test_deleting_a_review_recalculates_the_casinos_rating_avg(): void
    {
        $casino = Casino::factory()->create();

        Review::factory()->create([
            'casino_id' => $casino->id,
            'status' => 'published',
            'rating_payout' => 2,
            'rating_games' => 2,
            'rating_support' => 2,
            'rating_bonuses' => 2,
        ]);

        $reviewToDelete = Review::factory()->create([
            'casino_id' => $casino->id,
            'status' => 'published',
            'rating_payout' => 4,
            'rating_games' => 4,
            'rating_support' => 4,
            'rating_bonuses' => 4,
        ]);

        $this->assertEquals('3.00', $casino->fresh()->rating_avg);

        $reviewToDelete->delete();

        $this->assertEquals('2.00', $casino->fresh()->rating_avg);
    }
}
