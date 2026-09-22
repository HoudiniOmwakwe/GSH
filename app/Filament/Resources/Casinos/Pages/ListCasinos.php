<?php

namespace App\Filament\Resources\Casinos\Pages;

use App\Filament\Resources\Casinos\CasinoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCasinos extends ListRecords
{
    protected static string $resource = CasinoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
