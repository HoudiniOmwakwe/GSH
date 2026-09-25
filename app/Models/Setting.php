<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'site_name', 'contact_email', 'twitter_url', 'facebook_url', 'instagram_url',
    'default_meta_title', 'default_meta_description', 'analytics_id',
])]
class Setting extends Model
{
    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
