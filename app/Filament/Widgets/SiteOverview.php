<?php

namespace App\Filament\Widgets;

use App\Models\BlogPost;
use App\Models\Casino;
use App\Models\ContactMessage;
use App\Models\Review;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SiteOverview extends StatsOverviewWidget
{
    protected static ?int $sort = -2;

    protected function getStats(): array
    {
        return [
            Stat::make('Published casinos', Casino::where('status', 'published')->count())
                ->description(Casino::count().' total')
                ->icon('heroicon-o-building-storefront')
                ->color('success'),

            Stat::make('Published reviews', Review::where('status', 'published')->count())
                ->description(Review::count().' total')
                ->icon('heroicon-o-star')
                ->color('success'),

            Stat::make('Published posts', BlogPost::where('status', 'published')->count())
                ->description(BlogPost::count().' total')
                ->icon('heroicon-o-document-text')
                ->color('success'),

            Stat::make('Unread messages', ContactMessage::where('status', 'unread')->count())
                ->description(ContactMessage::count().' total')
                ->icon('heroicon-o-envelope')
                ->color(ContactMessage::where('status', 'unread')->count() > 0 ? 'danger' : 'gray'),
        ];
    }
}
