<?php

namespace App\Observers;

use App\Models\Review;

class ReviewObserver
{
    /**
     * Handle the Review "saving" event.
     */
    public function saving(Review $review): void
    {
        $review->rating_overall = collect([
            $review->rating_payout,
            $review->rating_games,
            $review->rating_support,
            $review->rating_bonuses,
        ])->avg();
    }

    /**
     * Handle the Review "saved" event.
     */
    public function saved(Review $review): void
    {
        $this->refreshCasinoRating($review);
    }

    /**
     * Handle the Review "deleted" event.
     */
    public function deleted(Review $review): void
    {
        $this->refreshCasinoRating($review);
    }

    private function refreshCasinoRating(Review $review): void
    {
        $casino = $review->casino;

        if (! $casino) {
            return;
        }

        $casino->update([
            'rating_avg' => $casino->reviews()->where('status', 'published')->avg('rating_overall') ?? 0,
        ]);
    }
}
