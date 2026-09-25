<?php

namespace App\Filament\Resources\ComparisonTables\Pages;

use App\Filament\Resources\ComparisonTables\ComparisonTableResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListComparisonTables extends ListRecords
{
    protected static string $resource = ComparisonTableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
