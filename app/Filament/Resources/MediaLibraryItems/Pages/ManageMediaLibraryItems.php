<?php

namespace App\Filament\Resources\MediaLibraryItems\Pages;

use App\Filament\Resources\MediaLibraryItems\MediaLibraryItemResource;
use Filament\Resources\Pages\ManageRecords;

class ManageMediaLibraryItems extends ManageRecords
{
    protected static string $resource = MediaLibraryItemResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
