<?php

namespace App\Models;

use App\Observers\ReviewObserver;
use Database\Factories\ReviewFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[Fillable([
    'casino_id', 'user_id', 'title', 'slug', 'body', 'pros', 'cons',
    'rating_payout', 'rating_games', 'rating_support', 'rating_bonuses', 'rating_overall',
    'status', 'published_at', 'meta_title', 'meta_description', 'canonical_url',
])]
#[ObservedBy(ReviewObserver::class)]
class Review extends Model
{
    /** @use HasFactory<ReviewFactory> */
    use HasFactory, HasSlug;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * @return BelongsTo<Casino, $this>
     */
    public function casino(): BelongsTo
    {
        return $this->belongsTo(Casino::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function casts(): array
    {
        return [
            'pros' => 'array',
            'cons' => 'array',
            'rating_payout' => 'decimal:1',
            'rating_games' => 'decimal:1',
            'rating_support' => 'decimal:1',
            'rating_bonuses' => 'decimal:1',
            'rating_overall' => 'decimal:1',
            'published_at' => 'datetime',
        ];
    }
}
