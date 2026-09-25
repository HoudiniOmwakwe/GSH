<?php

namespace App\Models;

use Database\Factories\ComparisonTableFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[Fillable(['name', 'slug', 'description', 'status'])]
class ComparisonTable extends Model
{
    /** @use HasFactory<ComparisonTableFactory> */
    use HasFactory, HasSlug;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * @return BelongsToMany<Casino, $this>
     */
    public function casinos(): BelongsToMany
    {
        return $this->belongsToMany(Casino::class, 'comparison_table_casino')
            ->withPivot('ordering')
            ->orderByPivot('ordering');
    }
}
