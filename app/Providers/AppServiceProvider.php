<?php

namespace App\Providers;

use App\Policies\MediaPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Media lives outside the App\Models namespace, so Laravel's policy
        // auto-discovery can't find MediaPolicy on its own.
        Gate::policy(Media::class, MediaPolicy::class);
    }
}
