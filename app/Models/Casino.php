<?php

namespace App\Models;

use Database\Factories\CasinoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[Fillable([
    'name', 'slug', 'type', 'summary', 'description', 'license_info', 'established_year',
    'website_url', 'affiliate_link', 'bonus_summary', 'status', 'is_featured', 'ordering',
    'meta_title', 'meta_description', 'canonical_url',
])]
class Casino extends Model implements HasMedia
{
    /** @use HasFactory<CasinoFactory> */
    use HasFactory, HasSlug, InteractsWithMedia;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
        $this->addMediaCollection('og_image')->singleFile();
    }

    /**
     * @return HasMany<Review, $this>
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * @return BelongsToMany<PaymentMethod, $this>
     */
    public function paymentMethods(): BelongsToMany
    {
        return $this->belongsToMany(PaymentMethod::class);
    }

    /**
     * @return BelongsToMany<ComparisonTable, $this>
     */
    public function comparisonTables(): BelongsToMany
    {
        return $this->belongsToMany(ComparisonTable::class, 'comparison_table_casino')
            ->withPivot('ordering')
            ->orderByPivot('ordering');
    }

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'rating_avg' => 'decimal:2',
            'established_year' => 'integer',
            'ordering' => 'integer',
        ];
    }
}
